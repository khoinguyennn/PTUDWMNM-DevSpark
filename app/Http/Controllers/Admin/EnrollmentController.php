<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('course_enrollments')
            ->join('users', 'course_enrollments.user_id', '=', 'users.id')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->leftJoin('users as instructors', 'courses.instructor_id', '=', 'instructors.id')
            ->select(
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'courses.id as course_id',
                'courses.title as course_title',
                'courses.price as course_price',
                'instructors.name as instructor_name',
                'course_enrollments.enrolled_at as enrollment_date',
                'course_enrollments.id as enrollment_id'
            );

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                  ->orWhere('users.email', 'LIKE', "%{$search}%")
                  ->orWhere('courses.title', 'LIKE', "%{$search}%");
            });
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('courses.id', $request->get('course_id'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('course_enrollments.enrolled_at', '>=', $request->get('date_from'));
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('course_enrollments.enrolled_at', '<=', $request->get('date_to'));
        }

        $enrollments = $query->orderBy('course_enrollments.enrolled_at', 'desc')->paginate(15);

        // Transform the data to add Carbon instances
        $enrollments->getCollection()->transform(function ($item) {
            $item->enrollment_date = \Carbon\Carbon::parse($item->enrollment_date);
            return $item;
        });

        // Get all courses for filter dropdown
        $courses = Course::orderBy('title')->get();

        // Statistics
        $totalEnrollments = DB::table('course_enrollments')->count();

        $totalRevenue = DB::table('course_enrollments')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->sum('courses.price');

        $uniqueStudents = DB::table('course_enrollments')
            ->distinct('user_id')
            ->count('user_id');

        $todayEnrollments = DB::table('course_enrollments')
            ->whereDate('enrolled_at', today())
            ->count();

        return view('admin.enrollments.index', compact(
            'enrollments', 
            'courses', 
            'totalEnrollments', 
            'totalRevenue', 
            'uniqueStudents', 
            'todayEnrollments'
        ));
    }

    public function create()
    {
        $users = User::where('role', 'student')->orderBy('name')->get();
        $courses = Course::orderBy('title')->get();
        
        return view('admin.enrollments.create', compact('users', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id'
        ]);

        try {
            DB::beginTransaction();

            // Check if enrollment already exists
            $existingEnrollment = DB::table('course_enrollments')
                ->where('user_id', $request->user_id)
                ->where('course_id', $request->course_id)
                ->exists();

            if ($existingEnrollment) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Học viên đã được ghi danh vào khóa học này rồi');
            }

            // Add to course_enrollments table
            DB::table('course_enrollments')->insert([
                'user_id' => $request->user_id,
                'course_id' => $request->course_id,
                'enrolled_at' => now(),
                'created_at' => now()
            ]);

            DB::commit();

            return redirect()->route('admin.enrollments.index')
                ->with('success', 'Đã ghi danh học viên thành công');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Enrollment creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi ghi danh: ' . $e->getMessage());
        }
    }

    public function show($userId, $courseId)
    {
        $enrollment = DB::table('course_enrollments')
            ->join('users', 'course_enrollments.user_id', '=', 'users.id')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->leftJoin('users as instructors', 'courses.instructor_id', '=', 'instructors.id')
            ->where('course_enrollments.user_id', $userId)
            ->where('course_enrollments.course_id', $courseId)
            ->select(
                'users.*',
                'courses.title as course_title',
                'courses.description as course_description',
                'courses.price as course_price',
                'instructors.name as instructor_name',
                'course_enrollments.enrolled_at as enrollment_date',
                'course_enrollments.id as enrollment_id'
            )
            ->first();

        if (!$enrollment) {
            return redirect()->route('admin.enrollments.index')
                ->with('error', 'Không tìm thấy thông tin ghi danh');
        }

        // Get user progress if available
        $progress = DB::table('user_progress')
            ->join('lessons', 'user_progress.lesson_id', '=', 'lessons.id')
            ->join('sections', 'lessons.section_id', '=', 'sections.id')
            ->where('user_progress.user_id', $userId)
            ->where('sections.course_id', $courseId)
            ->selectRaw('
                COUNT(*) as completed_lessons,
                (SELECT COUNT(*) FROM lessons 
                 JOIN sections ON lessons.section_id = sections.id 
                 WHERE sections.course_id = ?) as total_lessons,
                ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM lessons 
                       JOIN sections ON lessons.section_id = sections.id 
                       WHERE sections.course_id = ?)), 2) as progress_percentage,
                MAX(user_progress.updated_at) as updated_at
            ', [$courseId, $courseId])
            ->first();

        return view('admin.enrollments.show', compact('enrollment', 'progress'));
    }

    public function destroy($userId, $courseId)
    {
        try {
            DB::beginTransaction();

            // Check if enrollment exists
            $enrollment = DB::table('course_enrollments')
                ->where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();

            if (!$enrollment) {
                return redirect()->route('admin.enrollments.index')
                    ->with('error', 'Không tìm thấy thông tin ghi danh');
            }

            // Delete user progress for this course
            DB::table('user_progress')
                ->whereIn('lesson_id', function($query) use ($courseId) {
                    $query->select('lessons.id')
                          ->from('lessons')
                          ->join('sections', 'lessons.section_id', '=', 'sections.id')
                          ->where('sections.course_id', $courseId);
                })
                ->where('user_id', $userId)
                ->delete();

            // Delete from course_enrollments
            DB::table('course_enrollments')
                ->where('user_id', $userId)
                ->where('course_id', $courseId)
                ->delete();

            DB::commit();

            return redirect()->route('admin.enrollments.index')
                ->with('success', 'Đã hủy ghi danh thành công');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.enrollments.index')
                ->with('error', 'Có lỗi xảy ra khi hủy ghi danh');
        }
    }
}
