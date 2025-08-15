<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Course\app\Models\CourseLevel;

class CourseSelectedLevel extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'level_id'];

    function level() : BelongsTo {
        return $this->belongsTo(CourseLevel::class, 'level_id', 'id')->withDefault();
    }



}
