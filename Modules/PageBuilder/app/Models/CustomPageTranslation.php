<?php

namespace Modules\PageBuilder\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PageBuilder\Database\factories\CustomPageTranslationFactory;

class CustomPageTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'content', 'lang_code'];
    
}
