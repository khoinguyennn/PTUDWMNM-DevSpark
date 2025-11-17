<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Lesson;
use App\Models\UserProgress;
use App\Services\PayOSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    protected $payOSService;

    public function __construct(PayOSService $payOSService)
    {
        $this->payOSService = $payOSService;
    }
    public function index(Request $request)
    {
        $query = $request->get('search');
        
        // Nếu có tìm kiếm
        if ($query) {
            $featuredCourses = Course::with('instructor')
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                      ->orWhere('description', 'LIKE', "%{$query}%");
                })
                ->latest()
                ->take(12) // Hiển thị nhiều hơn khi tìm kiếm
                ->get();
                
            $freeCourses = collect(); // Không hiển thị free courses khi tìm kiếm
            $bannerCourses = collect(); // Không hiển thị banner khi tìm kiếm
            
            return view('home.index', compact('featuredCourses', 'bannerCourses', 'freeCourses', 'query'));
        }

        // Lấy các khóa học nổi bật (có thể random hoặc theo tiêu chí)
        $featuredCourses = Course::with('instructor')
            ->where('price', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        // Lấy khóa học cho banner slides
        $bannerCourses = Course::with('instructor')
            ->latest()
            ->take(3)
            ->get();

        // Lấy các khóa học miễn phí (giá = 0)
        $freeCourses = Course::with('instructor')
            ->where('price', 0)
            ->latest()
            ->take(6)
            ->get();

        return view('home.index', compact('featuredCourses', 'bannerCourses', 'freeCourses'));
    }

    public function allCourses(Request $request)
    {
        $query = $request->get('search');
        $sort = $request->get('sort', 'latest'); // latest, oldest, price_low, price_high
        
        $coursesQuery = Course::with('instructor')->where('price', '>', 0);
        
        // Apply search filter
        if ($query) {
            $coursesQuery->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }
        
        // Apply sorting
        switch ($sort) {
            case 'oldest':
                $coursesQuery->oldest();
                break;
            case 'price_low':
                $coursesQuery->orderBy('price', 'asc');
                break;
            case 'price_high':
                $coursesQuery->orderBy('price', 'desc');
                break;
            default:
                $coursesQuery->latest();
                break;
        }
        
        $courses = $coursesQuery->paginate(12)->appends(request()->query());
        
        return view('home.all-courses', compact('courses', 'query', 'sort'));
    }

    public function freeCourses(Request $request)
    {
        $query = $request->get('search');
        $sort = $request->get('sort', 'latest'); // latest, oldest
        
        $coursesQuery = Course::with('instructor')->where('price', 0);
        
        // Apply search filter
        if ($query) {
            $coursesQuery->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            });
        }
        
        // Apply sorting
        switch ($sort) {
            case 'oldest':
                $coursesQuery->oldest();
                break;
            default:
                $coursesQuery->latest();
                break;
        }
        
        $courses = $coursesQuery->paginate(12)->appends(request()->query());
        
        return view('home.free-courses', compact('courses', 'query', 'sort'));
    }

    public function show($id)
    {
        $course = Course::with(['instructor', 'sections.lessons'])
            ->findOrFail($id);

        // Kiểm tra xem người dùng đã đăng ký khóa học chưa
        $isEnrolled = false;
        if (Auth::check()) {
            // Kiểm tra trong bảng course_enrollments thay vì order_items
            $isEnrolled = DB::table('course_enrollments')
                ->where('user_id', Auth::id())
                ->where('course_id', $id)
                ->exists();

            // Nếu đã đăng ký, chuyển hướng đến trang học
            if ($isEnrolled) {
                return redirect()->route('course.learn', $id);
            }
        }

        // Tính tổng số bài học và tổng thời lượng
        $totalLessons = $course->sections->sum(function($section) {
            return $section->lessons->count();
        });

        $totalDuration = $course->sections->sum(function($section) {
            return $section->lessons->sum('duration');
        });

        return view('home.course-detail', compact('course', 'totalLessons', 'totalDuration', 'isEnrolled'));
    }

    public function learn($id)
    {
        $course = Course::with(['sections.lessons'])
            ->findOrFail($id);

        // Kiểm tra xem người dùng đã đăng ký khóa học chưa
        $isEnrolled = DB::table('course_enrollments')
            ->where('user_id', Auth::id())
            ->where('course_id', $id)
            ->exists();

        if (!$isEnrolled) {
            return redirect()->route('course.show', $id)
                ->with('error', 'Bạn cần đăng ký khóa học trước khi có thể học.');
        }

        // Lấy bài học đầu tiên để hiển thị
        $currentLesson = null;
        foreach ($course->sections as $section) {
            if ($section->lessons->count() > 0) {
                $currentLesson = $section->lessons->first();
                break;
            }
        }

        // Lấy tất cả tiến độ học tập của user cho khóa học này
        $lessonIds = [];
        foreach ($course->sections as $section) {
            foreach ($section->lessons as $lesson) {
                $lessonIds[] = $lesson->id;
            }
        }
        
        $completedLessons = UserProgress::where('user_id', Auth::id())
            ->whereIn('lesson_id', $lessonIds)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        // Kiểm tra tiến độ của bài học hiện tại
        $isCurrentLessonCompleted = false;
        if ($currentLesson) {
            $isCurrentLessonCompleted = in_array($currentLesson->id, $completedLessons);
        }

        return view('home.course-learn', compact('course', 'currentLesson', 'isCurrentLessonCompleted', 'completedLessons'));
    }

    public function enroll(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Kiểm tra xem đã đăng ký chưa
        $existingEnrollment = DB::table('course_enrollments')
            ->where('user_id', Auth::id())
            ->where('course_id', $id)
            ->exists();

        if ($existingEnrollment) {
            return redirect()->route('course.learn', $id);
        }

        // Nếu khóa học miễn phí (price = 0), đăng ký trực tiếp
        if ($course->price == 0) {
            try {
                DB::table('course_enrollments')->insert([
                    'user_id' => Auth::id(),
                    'course_id' => $course->id,
                    'enrolled_at' => now(),
                    'created_at' => now(),
                ]);

                return redirect()->route('course.learn', $id)->with('enrollment_success', true);

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Có lỗi xảy ra khi đăng ký khóa học. Vui lòng thử lại.');
            }
        }

        // Nếu khóa học có phí, chuyển hướng đến thanh toán PayOS
        try {
            DB::beginTransaction();

            // Tạo order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $course->price,
                'status' => 'pending'
            ]);

            // Tạo order item
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'price' => $course->price
            ]);

            // Generate unique order code
            $orderCode = intval(substr(strval(microtime(true) * 10000), -6));

            // Cập nhật order với order_code
            $order->update(['order_code' => $orderCode]);

            // Prepare payment data
            $user = Auth::user();
            $paymentData = [
                'order_code' => $orderCode,
                'amount' => (int)($course->price), // PayOS requires integer amount
                'description' => "Thanh toan khoa hoc", // Tối đa 25 ký tự
                'items' => [
                    [
                        'name' => mb_substr($course->title, 0, 20), // Giới hạn tên item
                        'quantity' => 1,
                        'price' => (int)($course->price)
                    ]
                ],
                'buyer_name' => $user->name,
                'buyer_email' => $user->email,
                'expired_at' => now()->addMinutes(15)->timestamp // 15 minutes expiry
            ];

            // Create payment link
            $result = $this->payOSService->createPaymentLink($paymentData);

            if ($result['success']) {
                DB::commit();
                
                // Redirect to PayOS checkout
                return redirect($result['data']['checkoutUrl']);
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Không thể tạo liên kết thanh toán: ' . $result['message']);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo thanh toán. Vui lòng thử lại.');
        }
    }

    public function markLessonComplete(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        try {
            $lesson = Lesson::findOrFail($request->lesson_id);
            
            // Kiểm tra xem người dùng đã đăng ký khóa học chưa
            $courseId = $lesson->section->course_id;
            $isEnrolled = DB::table('course_enrollments')
                ->where('user_id', Auth::id())
                ->where('course_id', $courseId)
                ->exists();

            if (!$isEnrolled) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chưa đăng ký khóa học này.'
                ], 403);
            }

            // Tạo hoặc cập nhật tiến độ học tập
            UserProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'lesson_id' => $request->lesson_id,
                ],
                [
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Đã đánh dấu bài học hoàn thành!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
