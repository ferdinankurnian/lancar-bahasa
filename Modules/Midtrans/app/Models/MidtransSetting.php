<?php

namespace Modules\Midtrans\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Midtrans\Database\factories\MidtransSettingFactory;

class MidtransSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['key', 'value'];
    
    protected static function newFactory(): MidtransSettingFactory
    {
        //return MidtransSettingFactory::new();
    }
}
