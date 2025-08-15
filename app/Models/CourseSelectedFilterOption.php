<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSelectedFilterOption extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'filter_id', 'filter_option_id'];

}
