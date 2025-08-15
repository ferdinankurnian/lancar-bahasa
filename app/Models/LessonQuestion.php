<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LessonQuestion extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'course_id',
        'question_title',
        'question_description',
        'seen',
    ];

    function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id', 'name', 'image');
    }
    function course(): BelongsTo {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    function lesson(): BelongsTo {
        return $this->belongsTo(CourseChapterLesson::class, 'lesson_id', 'id');
    }

    function replies(): HasMany {
        return $this->hasMany(LessonReply::class, 'question_id', 'id');
    }
    public function scopeSeen($query) {
        return $query->where('seen', 1);
    }
    public function scopeUnSeen($query) {
        return $query->where('seen', 0);
    }
}
