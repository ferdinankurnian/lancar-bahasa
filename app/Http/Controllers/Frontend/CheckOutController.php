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
        $products = Cart::content();

        foreach($products as $product) {
            if(in_array($product->id, session()->get('enrollments'))) {
                return redirect()->route('cart')->with(['messege' => __('Error occurred please try agin'), 'alert-type' => 'error']);
            }
            if(in_array($product->id, session()->get('enrollments'))) {
                return redirect()->route('cart')->with(['messege' => __('Error occurred please try agin'), 'alert-type' => 'error']);
            }
        }

        $cartTotal = $this->cartTotal();
        $discountPercent = Session::has('offer_percentage') ? Session::get('offer_percentage') : 0;
        $discountAmount = ($cartTotal * $discountPercent) / 100;
        $total = currency($cartTotal - $discountAmount);
        $coupon = Session::has('coupon_code') ? Session::get('coupon_code') : '';

        // Variables for Blade logic
        $has_coupon = Session::has('coupon_code');
        $payable_amount = $cartTotal; // Price before coupon
        $cartTotalAfterCoupon = $cartTotal - $discountAmount; // Price after coupon

        // Put the correct final amount in session for the backend controller
        Session::put('payable_amount', $cartTotalAfterCoupon);
        $user = userAuth();

        $basic_payment = $this->get_basic_payment_info();
        $payment_setting = $this->get_payment_gateway_info();

        /**start razorpay setting */
        $razorpay_calculate_charge = $this->calculate_payable_charge($payable_amount, 'razorpay');

        $razorpay_credentials = (object) [
            'currency_code' => $razorpay_calculate_charge->currency_code,
            'payable_with_charge' => $razorpay_calculate_charge->payable_with_charge,
            'razorpay_key' => $payment_setting->razorpay_key,
            'razorpay_secret' => $payment_setting->razorpay_secret,
            'razorpay_name' => $payment_setting->razorpay_name,
            'razorpay_description' => $payment_setting->razorpay_description,
            'razorpay_image' => $payment_setting->razorpay_image,
            'razorpay_theme_color' => $payment_setting->razorpay_theme_color,
            'razorpay_status' => $payment_setting->razorpay_status,
        ];
        /**end razorpay setting */

        /**start mollie setting */
        $mollie_credentials = (object) [
            'mollie_status' => $payment_setting->mollie_status,
            'mollie_image' => $payment_setting->mollie_image,
        ];
        /**end mollie setting */

        /**start instamojo setting */
        $instamojo_credentials = (object) [
            'instamojo_status' => $payment_setting->instamojo_status,
            'instamojo_image' => $payment_setting->instamojo_image,
        ];
        /**end instamojo setting */

        /**start flutterwave setting */
        $flutterwave_calculate_charge = $this->calculate_payable_charge($payable_amount, 'flutterwave');

        $flutterwave_credentials = (object) [
            'country_code' => $flutterwave_calculate_charge->country_code,
            'currency_code' => $flutterwave_calculate_charge->currency_code,
            'payable_with_charge' => $flutterwave_calculate_charge->payable_with_charge,
            'flutterwave_public_key' => $payment_setting->flutterwave_public_key,
            'flutterwave_secret_key' => $payment_setting->flutterwave_secret_key,
            'flutterwave_app_name' => $payment_setting->flutterwave_app_name,
            'flutterwave_status' => $payment_setting->flutterwave_status,
            'flutterwave_image' => $payment_setting->flutterwave_image,
        ];
        /**end flutterwave setting */

        /**start paystack setting */
        $paystack_calculate_charge = $this->calculate_payable_charge($payable_amount, 'paystack');

        $paystack_credentials = (object) [
            'country_code' => $paystack_calculate_charge->country_code,
            'currency_code' => $paystack_calculate_charge->currency_code,
            'payable_with_charge' => $paystack_calculate_charge->payable_with_charge,
            'paystack_public_key' => $payment_setting->paystack_public_key,
            'paystack_secret_key' => $payment_setting->paystack_secret_key,
            'paystack_status' => $payment_setting->paystack_status,
            'paystack_image' => $payment_setting->paystack_image,
        ];
        /**end paystack setting */

        /**start midtrans setting */
        $midtrans_info = MidtransSetting::get();
        $midtrans_payment_settings = [];
        foreach ($midtrans_info as $item) {
            $midtrans_payment_settings[$item->key] = $item->value;
        }
        $midtrans_credentials = (object) [
            'server_key' => $midtrans_payment_settings['server_key'] ?? '',
            'client_key' => $midtrans_payment_settings['client_key'] ?? '',
            'is_production' => filter_var($midtrans_payment_settings['is_production'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'status' => $midtrans_payment_settings['status'] ?? '0',
            'image' => $midtrans_payment_settings['image'], // Placeholder image, user can change later
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();
        } catch (Exception $e) {
            return redirect()->route('cart')->with(['messege' => 'Error: ' . $e->getMessage(), 'alert-type' => 'error']);
        }

        return view('frontend.pages.checkout')->with([
            'products' => $products,
            'total' => $total,
            'discountAmount' => $discountAmount,
            'discountPercent' => $discountPercent,
            'coupon' => $coupon,

            'basic_payment' => $basic_payment,
            'payable_amount' => $payable_amount,
            'cartTotalAfterCoupon' => $cartTotalAfterCoupon,
            'has_coupon' => $has_coupon,
            'payment_setting' => $payment_setting,
            'razorpay_credentials' => $razorpay_credentials,
            'mollie_credentials' => $mollie_credentials,
            'instamojo_credentials' => $instamojo_credentials,
            'flutterwave_credentials' => $flutterwave_credentials,
            'paystack_credentials' => $paystack_credentials,
            'midtrans_credentials' => $midtrans_credentials, // Added this line
            'user' => $user,
            'strip_key' => $basic_payment->stripe_key,
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
