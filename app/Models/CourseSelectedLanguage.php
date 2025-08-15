<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Course\app\Models\CourseLanguage;

class CourseSelectedLanguage extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'language_id'];

    function language() : HasOne
    {
        return $this->hasOne(CourseLanguage::class, 'id', 'language_id');
    }
}
