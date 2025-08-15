<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CoursePartnerInstructor extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'instructor_id'];

    function instructor() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'instructor_id');
    }
}
