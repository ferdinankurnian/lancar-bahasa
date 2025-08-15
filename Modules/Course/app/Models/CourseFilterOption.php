<?php

namespace Modules\Course\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Course\Database\factories\CourseFilterOptionFactory;

class CourseFilterOption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): CourseFilterOptionFactory
    {
        //return CourseFilterOptionFactory::new();
    }
}
