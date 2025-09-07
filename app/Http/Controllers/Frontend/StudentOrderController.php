<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Order\app\Models\Order;

class StudentOrderController extends Controller
{
    function index() {
        $orders = Order::where('buyer_id', userAuth()->id)->orderBy('id', 'desc')->paginate(30);
        return view('frontend.student-dashboard.order.index', compact('orders'));
    }

    function show(string $id) {
        $order = Order::where('id', $id)->where('buyer_id', userAuth()->id)->firstOrFail();
        return view('frontend.student-dashboard.order.show', compact('order'));
    }

    function printInvoice( Request $request, $id) {
        $order = Order::where('id', $id)->where('buyer_id', userAuth()->id)->firstOrFail();
       return view('frontend.student-dashboard.order.invoice', compact('order'));
    }

    public function cancelOrder(string $id)
    {
        $order = Order::where('id', $id)->where('buyer_id', userAuth()->id)->firstOrFail();

        if ($order->payment_status == 'pending') {
            $order->status = 'cancelled';
            $order->payment_status = 'cancelled';
            $order->save();

            // Optionally, you might want to refund the user or restock the items here.
            // For now, we'll just change the status.

            $notification = ['messege' => __('Transaction cancelled successfully!'), 'alert-type' => 'success'];
            return redirect()->back()->with($notification);
        } else {
            $notification = ['messege' => __('Only pending transactions can be cancelled.'), 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }
    }
}
