<?php

namespace Modules\PaymentWithdraw\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PaymentWithdraw\Database\factories\WithdrawRequestFactory;

class WithdrawRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'withdraw_amount',
        'method',
        'account_info',
        'status',
        'current_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email', 'image');
    }
}
