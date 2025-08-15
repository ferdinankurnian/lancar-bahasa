<?php

namespace Modules\SiteAppearance\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SiteAppearance\Database\factories\SectionSettingFactory;

class SectionSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    
}
