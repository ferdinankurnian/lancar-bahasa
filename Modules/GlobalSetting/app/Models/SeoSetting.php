<?php

namespace Modules\GlobalSetting\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\GlobalSetting\Database\factories\SeoSettingFactory;

class SeoSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): SeoSettingFactory
    {
        // return SeoSettingFactory::new();
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('setting');
            Cache::forget('seo_setting');
        });

        static::created(function () {
            Cache::forget('setting');
            Cache::forget('seo_setting');
        });

        static::updated(function () {
            Cache::forget('setting');
            Cache::forget('seo_setting');
        });

        static::deleted(function () {
            Cache::forget('setting');
            Cache::forget('seo_setting');
        });
    }
}
