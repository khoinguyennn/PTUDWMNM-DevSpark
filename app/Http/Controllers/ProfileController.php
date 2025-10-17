<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        $user = auth()->user();
        
        // Get user's orders count and total spent
        $ordersCount = $user->orders()->whereIn('status', ['paid', 'completed'])->count();
        $totalSpent = $user->orders()->whereIn('status', ['paid', 'completed'])->sum('total_amount');
        
        // Get user's enrolled courses count
        $enrolledCoursesCount = $user->enrolledCourses()->count();
        
        // Get recent orders
        $recentOrders = $user->orders()
            ->with(['orderItems.course'])
            ->latest()
            ->limit(5)
            ->get();
        
        return view('profile.show', compact('user', 'ordersCount', 'totalSpent', 'enrolledCoursesCount', 'recentOrders'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        flash()->success('Thông tin cá nhân đã được cập nhật thành công.');

        return redirect()->back();
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        flash()->success('Mật khẩu đã được thay đổi thành công.');

        return redirect()->back();
    }

    /**
     * Display user's purchased courses
     */
    public function myCourses()
    {
        $user = auth()->user();
        
        // Get courses from successful orders
        $purchasedCourses = collect();
        
        $successfulOrders = $user->orders()
            ->whereIn('status', ['paid', 'completed'])
            ->with(['orderItems.course.instructor', 'orderItems.course.sections.lessons'])
            ->get();
        
        foreach ($successfulOrders as $order) {
            foreach ($order->orderItems as $item) {
                if ($item->course) {
                    $course = $item->course;
                    
                    // Calculate progress for this course
                    $totalLessons = $course->sections->sum(function ($section) {
                        return $section->lessons->count();
                    });
                    
                    $completedLessons = 0;
                    if ($totalLessons > 0) {
                        $completedLessons = $user->progress()
                            ->whereHas('lesson.section', function ($query) use ($course) {
                                $query->where('course_id', $course->id);
                            })
                            ->where('is_completed', true)
                            ->count();
                    }
                    
                    $progressPercentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                    
                    // Add progress data to course
                    $course->total_lessons = $totalLessons;
                    $course->completed_lessons = $completedLessons;
                    $course->progress_percentage = $progressPercentage;
                    $course->purchase_date = $order->created_at;
                    
                    $purchasedCourses->push($course);
                }
            }
        }
        
        // Remove duplicates and sort by purchase date
        $purchasedCourses = $purchasedCourses->unique('id')->sortByDesc('purchase_date');
        
        return view('profile.my-courses', compact('purchasedCourses'));
    }
}
