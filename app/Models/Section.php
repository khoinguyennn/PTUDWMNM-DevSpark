<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'position',
    ];

    // Disable timestamps completely
    public $timestamps = false;

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship with Lessons
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }
}
