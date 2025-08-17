<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\GetGlobalInformationTrait;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Modules\Midtrans\app\Models\MidtransSetting;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Exception;

class CheckOutController extends Controller
{
    use GetGlobalInformationTrait;

    public function __construct()
    {
        // Set Midtrans configuration
        $midtrans_info = MidtransSetting::get();
        $midtrans_payment_settings = [];
        foreach ($midtrans_info as $item) {
            $midtrans_payment_settings[$item->key] = $item->value;
        }

        Config::$serverKey = isset($midtrans_payment_settings['server_key']) ? preg_replace('/\s+/', '', $midtrans_payment_settings['server_key']) : null;
        Config::$isProduction = (bool) ($midtrans_payment_settings['is_production'] ?? false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        if (Cart::content()->isEmpty()) {
            return redirect()->route('home')->with(['messege' => __('Your cart is empty'), 'alert-type' => 'warning']);
        }

        $products = Cart::content();
        foreach($products as $product) {
            if(in_array($product->id, session()->get('enrollments', []))) {
                return redirect()->route('cart')->with(['messege' => __('You have already enrolled in a course in your cart.'), 'alert-type' => 'error']);
            }
        }

        $user = userAuth();
        $cartTotal = $this->cartTotal();
        $discountPercent = Session::get('offer_percentage', 0);
        $discountAmount = ($cartTotal * $discountPercent) / 100;
        $payable_amount = $cartTotal - $discountAmount;
        $coupon_code = Session::get('coupon_code');

        // Get current currency details
        $current_currency = allCurrencies()->where('currency_code', getSessionCurrency())->first();

        $order = Order::create([
            'user_id' => $user->id,
            'buyer_id' => $user->id,
            'order_number' => uniqid(),
            'invoice_id' => 'INV-' . uniqid(),
            'payable_amount' => $payable_amount,
            'payable_with_charge' => $payable_amount,
            'payable_currency' => $current_currency->currency_code,
            'gateway_name' => 'Midtrans',
            'transaction_id' => null,
            'snap_token' => null,
            'payment_status' => 'unpaid',
            'paid_amount' => 0,
            'payment_details' => null,
            'gateway_charge' => 0,
            'status' => 'pending',
            'has_coupon' => Session::has('coupon_code') ? 1 : 0,
            'coupon_code' => $coupon_code,
            'coupon_discount_percent' => $discountPercent,
            'coupon_discount_amount' => $discountAmount,
            'payment_method' => 'Midtrans',
            'conversion_rate' => $current_currency->currency_rate,
            'commission_rate' => optional(Cache::get('setting'))->commission_rate ?? 0,
        ]);

        $item_details = [];
        foreach ($products as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'price' => $item->price,
                'course_id' => $item->id,
                'commission_rate' => $order->commission_rate,
            ]);
            $item_details[] = [
                'id' => $item->id,
                'price' => $item->price,
                'quantity' => 1,
                'name' => $item->name,
            ];
        }
        


        Cart::destroy();
        Session::forget(['coupon_code', 'offer_percentage', 'coupon_discount_amount']);

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_id,
                'gross_amount' => $order->payable_amount,
            ],
            'customer_details' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'item_details' => $item_details,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();
        } catch (Exception $e) {
            return redirect()->route('cart')->with(['messege' => 'Error: ' . $e->getMessage(), 'alert-type' => 'error']);
        }

        return view('frontend.pages.checkout')->with([
            'order' => $order,
            'snap_token' => $order->snap_token,
        ]);
    }

    public function midtransCallback(Request $request)
    {
        try {
            $notification = new Notification();
            
            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $order_id = $notification->order_id;
            $fraud = $notification->fraud_status;

            $order = Order::where('invoice_id', $order_id)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transaction == 'capture' || $transaction == 'settlement') {
                if ($fraud == 'accept') {
                    $order->payment_status = 'paid';
                    $order->transaction_id = $notification->transaction_id;
                    $order->payment_details = json_encode($notification->getResponse());
                    $order->save();
                }
            } else if ($transaction == 'cancel' || $transaction == 'deny' || $transaction == 'expire') {
                $order->payment_status = 'failed';
                $order->save();
            }

            return response()->json(['message' => 'Notification handled'], 200);

        } catch (Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function payWithMidtrans(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // If snap_token not yet generated (in case user directly accesses pay page)
        if (!$order->snap_token) {
            try {
                $params = [
                    'transaction_details' => [
                        'order_id' => $order->invoice_id,
                        'gross_amount' => $order->payable_amount,
                    ],
                    'customer_details' => [
                        'first_name' => $order->user->first_name ?? '',
                        'last_name' => $order->user->last_name ?? '',
                        'email' => $order->user->email ?? '',
                        'phone' => $order->user->phone ?? '',
                    ],
                ];
                $snapToken = Snap::getSnapToken($params);
                $order->snap_token = $snapToken;
                $order->save();
            } catch (Exception $e) {
                return redirect()->route('checkout.index')->with(['messege' => 'Error: ' . $e->getMessage(), 'alert-type' => 'error']);
            }
        }

        return view('frontend.pages.midtrans-pay', [
            'order' => $order,
            'snap_token' => $order->snap_token,
        ]);
    }

    public function orderCompleted(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('frontend.pages.order-completed', ['order' => $order]);
    }

    public function cartTotal()
    {
        $cartTotal = 0;
        $cartItems = Cart::content();
        foreach ($cartItems as $key => $cartItem) {
            $cartTotal += $cartItem->price;
        }
        return $cartTotal;
    }
}
