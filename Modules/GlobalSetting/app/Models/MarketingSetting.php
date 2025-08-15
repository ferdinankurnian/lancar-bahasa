<?php

namespace Modules\GlobalSetting\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\GlobalSetting\Database\factories\MarketingSettingFactory;

class MarketingSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['key', 'value'];

}
