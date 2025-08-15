<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLiveClass extends Model {
    use HasFactory;
    protected $fillable = [
        'lesson_id',
        'start_time',
        'meeting_id',
        'password',
        'join_url',
        'type',
    ];

    function lesson(): BelongsTo {
        return $this->belongsTo(CourseChapterLesson::class, 'lesson_id', 'id');
    }
}
