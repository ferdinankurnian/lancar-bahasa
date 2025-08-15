<?php

namespace Modules\PaymentGateway\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PaymentGateway\Database\factories\PaymentGatewayFactory;

class PaymentGateway extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): PaymentGatewayFactory
    {
        //return PaymentGatewayFactory::new();
    }
}
