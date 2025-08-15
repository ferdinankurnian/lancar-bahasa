<?php

namespace Modules\Course\app\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Course\Database\factories\CourseDeleteRequestFactory;

class CourseDeleteRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    function course() : BelongsTo {
        return $this->belongsTo(Course::class)->withTrashed();
    }

}
