<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseReview extends Model
{
    use HasFactory;

    protected $guarded = [];


    function course() : BelongsTo{
       return $this->belongsTo(Course::class); 
    }
    function user() : BelongsTo{
       return $this->belongsTo(User::class); 
    }
}
