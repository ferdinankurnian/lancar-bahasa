<?php

namespace Modules\Course\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Course\Database\factories\CourseCategoryTranslationFactory;

class CourseCategoryTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'course_category_id',
        'lang_code',
        'name',
    ];


    function courseCategory() : BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }
}
