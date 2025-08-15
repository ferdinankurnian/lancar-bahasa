<?php

namespace Modules\Order\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Database\factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_id',
        'buyer_id',
        'status',
        'has_coupon',
        'coupon_code',
        'coupon_discount_percent',
        'coupon_discount_amount',
        'payment_method',
        'payment_status',
        'payable_amount',
        'gateway_charge',
        'payable_with_charge',
        'paid_amount',
        'conversion_rate',
        'payable_currency',
        'payment_details',
        'transaction_id',
        'commission_rate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id')->select('id', 'name', 'email', 'image');
    }

    function orderItems() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id'); 
    }
}
