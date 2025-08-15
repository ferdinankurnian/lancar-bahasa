<?php

namespace Modules\InstructorRequest\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\InstructorRequest\Database\factories\InstructorRequestSettingTranslationFactory;

class InstructorRequestSettingTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'instructor_request_setting_id',
        'lang_code',
        'instructions'
    ];
}
