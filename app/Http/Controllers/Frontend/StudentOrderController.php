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
}
