<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;

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

        // Tính tổng số bài học và tổng thời lượng
        $totalLessons = $course->sections->sum(function($section) {
            return $section->lessons->count();
        });

        $totalDuration = $course->sections->sum(function($section) {
            return $section->lessons->sum('duration');
        });

        return view('home.course-detail', compact('course', 'totalLessons', 'totalDuration'));
    }
}
