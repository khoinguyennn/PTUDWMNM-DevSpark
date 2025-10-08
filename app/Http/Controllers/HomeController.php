<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Lesson;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
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

        try {
            DB::beginTransaction();

            // Chỉ cần tạo enrollment record trong course_enrollments
            DB::table('course_enrollments')->insert([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'enrolled_at' => now(),
                'created_at' => now(),
            ]);

            // Nếu khóa học có phí, tạo order record để theo dõi thanh toán
            if ($course->price > 0) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_amount' => $course->price,
                    'status' => 'pending', // Chờ thanh toán
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'course_id' => $course->id,
                    'price' => $course->price,
                ]);
            }

            DB::commit();

            return redirect()->route('course.learn', $id)
                ->with('success', 'Đăng ký khóa học thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi đăng ký khóa học. Vui lòng thử lại.');
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
