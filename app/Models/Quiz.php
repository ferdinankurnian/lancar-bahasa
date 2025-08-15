<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_item_id',
        'instructor_id',
        'chapter_id',
        'course_id',
        'title',
        'time',
        'attempt',
        'pass_mark',
        'total_mark',
        'status',
    ];

    function questions() : HasMany
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id', 'id');
    }

    function lessonProgress() : HasOne
    {
        return $this->hasOne(CourseProgress::class, 'lesson_id', 'id');
    }

    function instructor() : BelongsTo{
       return $this->belongsTo(User::class, 'instructor_id', 'id'); 
    }
    function course() : BelongsTo{
        return $this->belongsTo(Course::class, 'course_id', 'id')->withTrashed(); 
    }
    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($quiz) {
            $quiz->questions()->each(function ($question) {
                $question->delete();
            });
            if ($quiz->lessonProgress) {
                $quiz->lessonProgress->delete();
            }
        });
    }
}
