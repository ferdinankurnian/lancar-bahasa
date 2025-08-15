<?php

namespace Modules\Language\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'direction',
        'status',
        'is_default',
        'image',
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = str_replace(' ', '-', strtolower($value));
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('allLanguages');
        });

        static::created(function () {
            Cache::forget('allLanguages');
        });

        static::updated(function () {
            Cache::forget('allLanguages');
        });

        static::deleted(function () {
            Cache::forget('allLanguages');
        });
    }
}
