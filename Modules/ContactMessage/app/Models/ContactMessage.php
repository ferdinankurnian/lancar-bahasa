<?php

namespace Modules\ContactMessage\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ContactMessage\Database\factories\ContactMessageFactory;

class ContactMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): ContactMessageFactory
    {
        //return ContactMessageFactory::new();
    }
}
