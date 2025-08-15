<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\app\Models\CourseCategory;
use Modules\Order\app\Models\Enrollment;

class Course extends Model {
    use HasFactory, SoftDeletes;

    function scopeActive() {
        return $this->where(['is_approved' => 'approved', 'status' => 'active']);
    }

    function partnerInstructors(): HasMany {
        return $this->hasMany(CoursePartnerInstructor::class, 'course_id', 'id');
    }

    function levels(): HasMany {
        return $this->hasMany(CourseSelectedLevel::class, 'course_id', 'id');
    }
    function languages(): HasMany {
        return $this->hasMany(CourseSelectedLanguage::class, 'course_id', 'id');
    }

    function filtersOptions(): HasMany {
        return $this->hasMany(CourseSelectedFilterOption::class, 'course_id', 'id');
    }

    function category(): BelongsTo {
        return $this->belongsTo(CourseCategory::class, 'category_id', 'id')->withDefault();
    }

    function instructor(): BelongsTo {
        return $this->belongsTo(User::class, 'instructor_id', 'id')->withDefault();
    }

    function chapters(): HasMany {
        return $this->hasMany(CourseChapter::class, 'course_id', 'id');
    }

    function reviews(): HasMany {
        return $this->hasMany(CourseReview::class, 'course_id', 'id');
    }
    function lessons(): HasMany {
        return $this->hasMany(CourseChapterLesson::class, 'course_id', 'id');
    }

    function enrollments(): HasMany {
        return $this->hasMany(Enrollment::class, 'course_id', 'id');
    }
    /**
     * Boot method to handle model events.
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function ($course) {
            // Delete related chapters
            $course->chapters()->each(function ($chapter) {
                $chapter->delete();
            });

            // Delete related partner instructors
            $course->partnerInstructors()->each(function ($instructor) {
                $instructor->delete();
            });

            // Delete related levels
            $course->levels()->each(function ($level) {
                $level->delete();
            });

            // Delete related languages
            $course->languages()->each(function ($language) {
                $language->delete();
            });

            // Delete related filter options
            $course->filtersOptions()->each(function ($filterOption) {
                $filterOption->delete();
            });

            // Delete related reviews
            $course->reviews()->each(function ($review) {
                $review->delete();
            });
        });
    }
}
