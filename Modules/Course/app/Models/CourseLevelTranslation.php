<?php

namespace Modules\Course\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Course\Database\factories\CourseLevelTranslationFactory;

class CourseLevelTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'course_level_id',
        'lang_code',
        'name',
    ];

    function courseLevel() : BelongsTo
    {
        return $this->belongsTo(CourseLevel::class, 'course_level_id');
    }

}
