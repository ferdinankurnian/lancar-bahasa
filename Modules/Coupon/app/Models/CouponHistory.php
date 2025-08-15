<?php

namespace Modules\Coupon\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Coupon\Database\factories\CouponHistoryFactory;

class CouponHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): CouponHistoryFactory
    {
        //return CouponHistoryFactory::new();
    }
}
