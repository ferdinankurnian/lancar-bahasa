<?php

namespace Modules\NewsLetter\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\NewsLetter\Database\factories\NewsLetterFactory;

class NewsLetter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): NewsLetterFactory
    {
        //return NewsLetterFactory::new();
    }
}
