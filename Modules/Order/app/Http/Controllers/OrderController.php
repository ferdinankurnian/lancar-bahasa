<?php

namespace Modules\Order\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Order\app\Jobs\PaymentRejectJob;
use Modules\Order\app\Models\Enrollment;
use Modules\Order\app\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        checkAdminHasPermissionAndThrowException('order.management');

        $query = Order::query();
        $query->when($request->keyword, fn ($q) => $q->where('invoice_id', 'like', "%{$request->keyword}%"));
        $query->when($request->order_status, fn ($q) => $q->where('status', $request->order_status));
        $query->when($request->payment_status, fn ($q) => $q->where('payment_status', $request->payment_status));
        $orderBy = $request->order_by == 1 ? 'asc' : 'desc';
        $orders = $request->get('par-page') == 'all' ?
            $query->orderBy('id', $orderBy)->get() :
            $query->orderBy('id', $orderBy)->paginate($request->get('par-page') ?? null)->withQueryString();

        $title = __('Order History');

        return view('order::index', ['orders' => $orders, 'title' => $title]);
    }

    public function pending_order()
    {

        checkAdminHasPermissionAndThrowException('order.management');

        $orders = Order::with('user')->where('payment_status', 'pending')->latest()->paginate();
        $title = __('Pending Order');

        return view('order::pending-orders', ['orders' => $orders, 'title' => $title]);
    }

    public function show(string $id)
    {
        checkAdminHasPermissionAndThrowException('order.management');

        $order = Order::where('id', $id)->firstOrFail();

        return view('order::show', ['order' => $order]);
    }

    function updateOrder(Request $request, $id)
    {
        checkAdminHasPermissionAndThrowException('order.management');

        $order = Order::findOrFail($id);
        $order->status = $request->order_status;
        $order->payment_status = $request->payment_status;
        $order->save();

        if ($request->payment_status == 'paid') {
            foreach ($order->orderItems as $item) {

                Enrollment::create([
                    'order_id' => $order->id,
                    'user_id' => $order->buyer_id,
                    'course_id' => $item->course_id,
                    'has_access' => 1,
                ]);

                // insert instructor commission to his wallet
                $commissionAmount = $item->price * ($order->commission_rate / 100);
                $amountAfterCommission = $item->price - $commissionAmount;
                $instructor = Course::find($item->course_id)->instructor;
                $instructor->increment('wallet_balance', $amountAfterCommission);
            }
        }else {

            foreach ($order->orderItems as $item) {
                // delete enrollment
                $enrollment = Enrollment::where('user_id', $order->buyer_id)->where('course_id', $item->course_id)->first();
                $enrollment->delete();
                // decrement instructor commission from his wallet
                $commissionAmount = $item->price * ($order->commission_rate / 100);
                $amountAfterCommission = $item->price - $commissionAmount;
                $instructor = Course::find($item->course_id)->instructor;
                $instructor->decrement('wallet_balance', $amountAfterCommission);
            }
        }

        $notification = __('order status updated successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function printInvoice(Request $request, $id) {
       $order = Order::where('id', $id)->firstOrFail();
       return view('order::invoice', ['order' => $order]); 
    }

    public function destroy($id)
    {
        checkAdminHasPermissionAndThrowException('order.management');

        // delete order and order items order enrollments and instructor commission
        $order = Order::findOrFail($id);
        if($order?->payment_status == 'paid') {
            foreach ($order?->orderItems as $item) {
                // delete enrollment
                $enrollment = Enrollment::where('user_id', $order?->buyer_id)->where('course_id', $item?->course_id)->first();
                if($enrollment) $enrollment->delete();
                // decrement instructor commission from his wallet
                $commissionAmount = $item?->price * ($order?->commission_rate / 100);
                $amountAfterCommission = $item?->price - $commissionAmount;
                $instructor = Course::find($item?->course_id)?->instructor;
                $instructor?->decrement('wallet_balance', $amountAfterCommission);
            }
         }
        $order->orderItems()->delete();
        $order->delete();

        $notification = __('Order deleted successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.orders')->with($notification);
    }
}
