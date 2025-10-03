<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Course;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function create(Course $course)
    {
        return view('admin.sections.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'position' => 'required|integer|min:1',
        ]);

        $course->sections()->create($validated);

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Chương học đã được tạo thành công!');
    }

    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'position' => 'required|integer|min:1',
        ]);

        $section->update($validated);

        return redirect()->route('admin.courses.show', $section->course)
            ->with('success', 'Chương học đã được cập nhật thành công!');
    }

    public function destroy(Section $section)
    {
        $course = $section->course;
        $section->delete();

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Chương học đã được xóa thành công!');
    }
}
