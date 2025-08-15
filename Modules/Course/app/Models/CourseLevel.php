<?php

namespace Modules\Course\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Course\Database\factories\CourseLevelFactory;

class CourseLevel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['slug', 'status'];


    public function getTranslation($code): ?CourseLevelTranslation
    {
        return $this->hasOne(CourseLevelTranslation::class)->where('lang_code', $code)->first();
    }
    public function translation(): ?HasOne
    {
        return $this->hasOne(CourseLevelTranslation::class)->where('lang_code', getSessionLanguage());
    }
    public function translations(): ?HasMany
    {
        return $this->hasMany(CourseLevelTranslation::class, 'course_level_id');
    }


}
