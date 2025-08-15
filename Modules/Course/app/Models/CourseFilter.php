<?php

namespace Modules\Course\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Course\Database\factories\CourseFilterFactory;

class CourseFilter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['course_category_id'];

    public function getTranslation($code): ?CourseFilterTranslation
    {
        return $this->hasOne(CourseFilterTranslation::class)->where('lang_code', $code)->first();
    }
    public function translation(): ?HasOne
    {
        return $this->hasOne(CourseFilterTranslation::class)->where('lang_code', getSessionLanguage());
    }
    public function translations(): ?HasMany
    {
        return $this->hasMany(CourseFilterTranslation::class, 'course_filter_id');
    }

    function filterOptions() : HasMany {
        return $this->hasMany(CourseFilterOption::class, 'filter_id');
    }

    function category() : BelongsTo {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

}
