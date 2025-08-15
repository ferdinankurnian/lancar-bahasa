<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class CourseChapterItem extends Model {
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'chapter_id',
        'type',
        'order',
    ];

    function lesson(): HasOne {
        return $this->hasOne(CourseChapterLesson::class, 'chapter_item_id', 'id');
    }

    function chapter(): BelongsTo {
        return $this->belongsTo(CourseChapter::class, 'chapter_id', 'id');
    }

    function quiz(): HasOne {
        return $this->hasOne(Quiz::class, 'chapter_item_id', 'id');
    }

    function quizzes(): HasMany {
        return $this->hasMany(Quiz::class, 'chapter_item_id', 'id');
    }
    /**
     * Boot method to handle model events.
     */
    protected static function boot() {
        parent::boot();
        static::deleting(function ($courseChapterItem) {
            $courseChapterItem->quizzes()->each(function ($quiz) {
                $quiz->delete();
            });
            if ($courseChapterItem->lesson) {
                $courseChapterItem->lesson->delete();
            }
            if ($courseChapterItem->live) {
                $courseChapterItem->live->delete();
            }
        });
    }
}
