<?php

namespace Modules\PaymentWithdraw\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PaymentWithdraw\Database\factories\WithrawMethodFactory;

class WithdrawMethod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): WithrawMethodFactory
    {
        //return WithrawMethodFactory::new();
    }
}
