<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor', 'sections.lessons')
            ->latest()
            ->paginate(10);
        
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $instructors = User::where('role', 'instructor')->get();
        return view('admin.courses.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'title' => 'required|max:200',
            'description' => 'required',
            'learning_outcomes' => 'nullable|array',
            'learning_outcomes.*' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Khóa học đã được tạo thành công!');
    }

    public function edit(Course $course)
    {
        $instructors = User::where('role', 'instructor')->get();
        return view('admin.courses.edit', compact('course', 'instructors'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'title' => 'required|max:200',
            'description' => 'required',
            'learning_outcomes' => 'nullable|array',
            'learning_outcomes.*' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Khóa học đã được cập nhật thành công!');
    }

    public function destroy(Course $course)
    {
        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Khóa học đã được xóa thành công!');
    }

    public function show(Course $course)
    {
        $course->load('instructor', 'sections.lessons');
        return view('admin.courses.show', compact('course'));
    }
}
