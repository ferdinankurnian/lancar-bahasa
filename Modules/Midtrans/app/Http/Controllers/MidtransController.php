<?php

namespace Modules\Midtrans\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Midtrans\app\Models\MidtransSetting;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Course;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Frontend\CartController;

class MidtransController extends Controller
{
    public function index()
    {
        // checkAdminHasPermissionAndThrowException('midtrans.payment.view'); // Permission check can be added later
        $payment_info = MidtransSetting::get();

        $midtrans_payment = [];

        foreach ($payment_info as $payment_item) {
            $midtrans_payment[$payment_item->key] = $payment_item->value;
        }

        $midtrans_payment = (object) $midtrans_payment;

        return view('midtrans::index', compact('midtrans_payment'));
    }

    public function update(Request $request)
    {
        // checkAdminHasPermissionAndThrowException('midtrans.payment.update'); // Permission check can be added later
        $rules = [
            'server_key'         => 'required',
            'client_key'      => 'required',
        ];
        $customMessages = [
            'server_key.required'         => __('Midtrans server key is required'),
            'client_key.required'      => __('Midtrans client key is required'),
        ];

        $request->validate($rules, $customMessages);

        MidtransSetting::updateOrCreate(['key' => 'server_key'], ['value' => $request->server_key]);
        MidtransSetting::updateOrCreate(['key' => 'client_key'], ['value' => $request->client_key]);
        MidtransSetting::updateOrCreate(['key' => 'is_production'], ['value' => $request->is_production]);
        MidtransSetting::updateOrCreate(['key' => 'status'], ['value' => $request->status]);

        $this->put_midtrans_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    

    public function createTransaction(Request $request)
    {
        // Get Midtrans credentials
        $midtrans_info = MidtransSetting::get();
        $midtrans_payment_settings = [];
        foreach ($midtrans_info as $item) {
            $midtrans_payment_settings[$item->key] = $item->value;
        }

        $serverKey = $midtrans_payment_settings['server_key'] ?? '';
        $isProduction = filter_var($midtrans_payment_settings['is_production'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Set Midtrans configuration
        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = $isProduction;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $user = Auth::user();

        // Get the payable amount from the session, which is calculated in CartController
        $payable_amount = Session::get('payable_amount', (int) Cart::total(2, '.', ''));

        // Create a pending order in our database
        $order = Order::create([
            'invoice_id' => Str::random(10),
            'buyer_id' => $user->id,
            'status' => 'pending', // Set status to pending
            'has_coupon' => Session::has('coupon_code') ? 1 : 0,
            'coupon_code' => Session::get('coupon_code'),
            'coupon_discount_percent' => Session::get('offer_percentage'),
            'coupon_discount_amount' => Session::get('coupon_discount_amount'),
            'payment_method' => 'Midtrans',
            'payment_status' => 'pending',
            'payable_amount' => $payable_amount,
            'gateway_charge' => 0, // Adjust if Midtrans has gateway charge
            'payable_with_charge' => $payable_amount, // Assuming no extra charge for now
            'paid_amount' => 0, // Will be updated after successful payment
            'conversion_rate' => 1,
            'payable_currency' => getSessionCurrency(),
            'payment_details' => null, // Will be updated after successful payment
            'transaction_id' => null, // Will be updated after successful payment
            'commission_rate' => \Cache::get('setting')->commission_rate,
        ]);

        // Store order_id in session to retrieve it in payment_addon_success
        Session::put('current_order_id', $order->id);

        $itemDetails = [];
        foreach (Cart::content() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'price' => $item->price,
                'course_id' => $item->id,
                'commission_rate' => \Cache::get('setting')->commission_rate,
            ]);
            $itemDetails[] = [
                'id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->qty,
                'name' => $item->name,
            ];
        }

        // If a coupon is applied, add it as a separate item with a negative value
        if (Session::has('coupon_code')) {
            $itemDetails[] = [
                'id' => 'COUPON_' . Session::get('coupon_code'),
                'price' => -(int)Session::get('coupon_discount_amount'),
                'quantity' => 1,
                'name' => 'Coupon Discount'
            ];
        }

        $transactionDetails = [
            'order_id' => $order->invoice_id, // Use invoice_id as order_id for Midtrans
            'gross_amount' => $payable_amount,
        ];

        $customerDetails = [
            'first_name' => $user->name ?? 'Guest',
            'email' => $user->email ?? 'guest@example.com',
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('midtrans.callback.success'),
                'unfinish' => route('order-unfinish'),
                'error' => route('order-fail'),
            ],
            'notification_url' => route('midtrans.callback.success'),
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function put_midtrans_payment_cache()
    {
        $payment_info = MidtransSetting::get();
        $midtrans_payment = [];
        foreach ($payment_info as $payment_item) {
            $midtrans_payment[$payment_item->key] = $payment_item->value;
        }
        $midtrans_payment = (object) $midtrans_payment;
        \Cache::put('midtrans_payment', $midtrans_payment);
    }
}