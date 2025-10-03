<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
}
