<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    /**
     * Display instructor dashboard
     */
    public function dashboard()
    {
        $instructor = Auth::user();

        // Get instructor's courses
        $courses = Course::where('instructor_id', $instructor->id)
            ->withCount('sections', 'enrollments')
            ->latest()
            ->get();

        // Statistics
        $totalCourses = $courses->count();
        $totalEnrollments = DB::table('course_enrollments')
            ->whereIn('course_id', $courses->pluck('id'))
            ->count();

        $totalRevenue = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->whereIn('order_items.course_id', $courses->pluck('id'))
            ->where('orders.status', 'paid')
            ->sum('orders.total_amount');

        return view('instructor.dashboard', compact(
            'courses',
            'totalCourses',
            'totalEnrollments',
            'totalRevenue'
        ));
    }

    /**
     * Display instructor's courses
     */
    public function courses()
    {
        $instructor = Auth::user();

        $courses = Course::where('instructor_id', $instructor->id)
            ->withCount(['sections', 'enrollments'])
            ->latest()
            ->paginate(10);

        return view('instructor.courses.index', compact('courses'));
    }

    /**
     * Display enrollments for instructor's courses
     */
    public function enrollments()
    {
        $instructor = Auth::user();

        $courseIds = Course::where('instructor_id', $instructor->id)->pluck('id');

        $enrollments = DB::table('course_enrollments')
            ->join('users', 'course_enrollments.user_id', '=', 'users.id')
            ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
            ->whereIn('course_enrollments.course_id', $courseIds)
            ->select(
                'course_enrollments.*',
                'users.name as student_name',
                'users.email as student_email',
                'courses.title as course_title'
            )
            ->orderBy('course_enrollments.enrolled_at', 'desc')
            ->paginate(15);

        return view('instructor.enrollments.index', compact('enrollments'));
    }

    /**
     * Display instructor profile
     */
    public function profile()
    {
        $instructor = Auth::user();

        return view('instructor.profile.show', compact('instructor'));
    }

    /**
     * Update instructor profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $instructor = Auth::user();

        // Update basic info
        $instructor->name = $request->name;
        $instructor->email = $request->email;

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('password')) {
            if (!\Hash::check($request->current_password, $instructor->password)) {
                return back()->with('error', 'Mật khẩu hiện tại không đúng.');
            }

            $instructor->password = \Hash::make($request->password);
        }

        $instructor->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    /**
     * Display specific course details
     */
    public function courseDetail($id)
    {
        $instructor = Auth::user();

        $course = Course::where('id', $id)
            ->where('instructor_id', $instructor->id)
            ->with(['sections.lessons', 'enrollments'])
            ->firstOrFail();

        // Get enrollment statistics
        $enrollmentStats = [
            'total' => $course->enrollments->count(),
            'this_month' => $course->enrollments()
                ->whereMonth('enrolled_at', now()->month)
                ->count(),
            'this_week' => $course->enrollments()
                ->whereBetween('enrolled_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];

        return view('instructor.courses.detail', compact('course', 'enrollmentStats'));
    }
}

