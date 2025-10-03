<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Disable updated_at timestamp
    const UPDATED_AT = null;

    protected $fillable = [
        'instructor_id',
        'title',
        'description',
        'price',
        'thumbnail',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Relationship with User (Instructor)
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // Relationship with Sections
    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('position');
    }

    // Relationship with Orders through order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Get total lessons count
    public function getTotalLessonsAttribute()
    {
        return $this->sections->sum(function ($section) {
            return $section->lessons->count();
        });
    }

    // Get total duration
    public function getTotalDurationAttribute()
    {
        return $this->sections->sum(function ($section) {
            return $section->lessons->sum('duration');
        });
    }
}
