<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function create(Section $section)
    {
        return view('admin.lessons.create', compact('section'));
    }

    public function store(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'youtube_url' => 'required|max:255',
            'duration' => 'required|integer|min:1',
            'position' => 'required|integer|min:1',
        ]);

        $section->lessons()->create($validated);

        return redirect()->route('admin.courses.show', $section->course)
            ->with('success', 'Bài học đã được tạo thành công!');
    }

    public function edit(Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'youtube_url' => 'required|max:255',
            'duration' => 'required|integer|min:1',
            'position' => 'required|integer|min:1',
        ]);

        $lesson->update($validated);

        return redirect()->route('admin.courses.show', $lesson->section->course)
            ->with('success', 'Bài học đã được cập nhật thành công!');
    }

    public function destroy(Lesson $lesson)
    {
        $course = $lesson->section->course;
        $lesson->delete();

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Bài học đã được xóa thành công!');
    }
}
