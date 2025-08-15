<?php

namespace Modules\SocialLink\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SocialLink\Database\factories\SocialLinkFactory;

class SocialLink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['link', 'icon'];
}
