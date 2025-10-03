<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'youtube_url',
        'duration',
        'position',
    ];

    // Disable timestamps completely  
    public $timestamps = false;

    // Relationship with Section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Relationship with User Progress
    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }
}
