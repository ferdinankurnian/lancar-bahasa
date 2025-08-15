<?php

namespace Modules\Order\app\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Order\Database\factories\OrderItemFactory;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id' => 'order_id',
        'price' => 'price',
        'course_id' => 'course_id',
        'commission_rate' => 'commission_rate',
    ];

    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id')->withTrashed();
    }

    function order() : HasOne{
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
