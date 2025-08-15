<?php

namespace Modules\Refund\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\app\Models\Order;
use Modules\Refund\Database\factories\RefundRequestFactory;

class RefundRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): RefundRequestFactory
    {
        //return RefundRequestFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email', 'image');
    }

    public function order()
    {
        return $this->belongsTo(Order::class)->select('id', 'order_id');
    }
}
