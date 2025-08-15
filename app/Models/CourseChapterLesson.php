<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CourseChapterLesson extends Model {
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'chapter_id',
        'chapter_item_id',
        'file_path',
        'storage',
        'file_type',
        'volume',
        'instructor_id',
        'duration',
        'is_free',
    ];

    function lessonProgress(): HasOne {
        return $this->hasOne(CourseProgress::class, 'lesson_id', 'id');
    }
    function course(): BelongsTo {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    function chapterItem(): BelongsTo {
        return $this->belongsTo(CourseChapterItem::class, 'chapter_item_id', 'id');
    }
    function live(): HasOne {
        return $this->hasOne(CourseLiveClass::class, 'lesson_id', 'id');
    }
    protected static function boot() {
        parent::boot();

        static::deleting(function ($courseChapterLesson) {
            $courseChapterLesson->lessonProgress()->delete();
        });
    }
}
