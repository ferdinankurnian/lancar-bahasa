<?php

namespace Modules\Midtrans\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Midtrans\app\Models\MidtransSetting;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Http\Controllers\Frontend\PaymentController;
use Modules\Order\app\Models\Order;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Modules\Order\app\Models\OrderItem;
use Modules\Order\app\Models\Enrollment;
use App\Models\Course;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = 'midtrans-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/website-images'), $image_name);
            $image_path = 'uploads/website-images/' . $image_name;
            MidtransSetting::updateOrCreate(['key' => 'image'], ['value' => $image_path]);
        }

        $this->put_midtrans_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function process()
    {
        // Payment processing logic will be implemented here
    }

    public function notify(Request $request)
    {
        $midtrans_info = MidtransSetting::get();
        $midtrans_payment_settings = [];
        foreach ($midtrans_info as $item) {
            $midtrans_payment_settings[$item->key] = $item->value;
        }

        Config::$serverKey = $midtrans_payment_settings['server_key'] ?? '';
        Config::$isProduction = filter_var($midtrans_payment_settings['is_production'] ?? false, FILTER_VALIDATE_BOOLEAN);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;
        $grossAmount = $notification->gross_amount;
        $paymentType = $notification->payment_type;

        $order = Order::where('invoice_id', $orderId)->first();

        if (!$order) {
            // Order not found, log an error or return a 404
            \Log::error("Midtrans Webhook: Order with ID {$orderId} not found.");
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Handle different transaction statuses
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->payment_status = 'pending';
                $order->status = 'processing';
            } else if ($fraudStatus == 'accept') {
                $order->payment_status = 'paid';
                $order->status = 'completed';
                $order->paid_amount = $grossAmount;
            }
        } else if ($transactionStatus == 'settlement') {
            $order->payment_status = 'paid';
            $order->status = 'completed';
            $order->paid_amount = $grossAmount;
        } else if ($transactionStatus == 'pending') {
            $order->payment_status = 'pending';
            $order->status = 'pending';
        } else if ($transactionStatus == 'deny') {
            $order->payment_status = 'cancelled';
            $order->status = 'declined';
        } else if ($transactionStatus == 'expire') {
            $order->payment_status = 'cancelled';
            $order->status = 'declined';
        } else if ($transactionStatus == 'cancel') {
            $order->payment_status = 'cancelled';
            $order->status = 'declined';
        }

        $order->save();

        // If payment is successful, call the process successful payment logic
        if ($order->payment_status == 'paid' && $order->status == 'completed') {
            $paymentController = new PaymentController();
            $paymentController->_processSuccessfulPayment(
                $order, // Lewatin objek Order yang udah ada
                $paymentType, // Ini adalah gateway_name
                $order->transaction_id, // Ini adalah transaction
                json_decode($order->payment_details, true) // Ini adalah paymentDetails
            );
        }

        return response()->json(['message' => 'Webhook handled successfully'], 200);
    }

    public function finish(Request $request)
    {
        // Retrieve order ID from request or session
        $orderId = $request->query('order_id') ?? Session::get('midtrans_order_id'); // Assuming order_id is passed in query or session

        if ($orderId) {
            $order = Order::where('invoice_id', $orderId)->first();

            if ($order) {
                // Update order status to completed and paid
                $order->payment_status = 'paid';
                $order->status = 'completed';
                $order->save();

                // Call _processSuccessfulPayment to handle post-payment actions
                $paymentController = new PaymentController();
                $paymentController->_processSuccessfulPayment(
                    $order,
                    $order->payment_method, // Assuming payment_method is gateway_name
                    $order->transaction_id,
                    json_decode($order->payment_details, true)
                );
            }
        }

        return view('frontend.pages.order-success');
    }

    public function unfinish()
    {
        // Logic for uncompleted payment redirect
        return view('frontend.pages.order-unfinish');
    }

    public function error()
    {
        // Logic for payment error redirect
        return view('frontend.pages.order-fail');
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

        // Prepare transaction details
        $orderId = 'ORDER-' . uniqid(); // Generate a unique order ID
        $grossAmount = Session::get('payable_amount'); // Amount from session

        // Retrieve other necessary data from session
        $payable_with_charge = Session::get('payable_with_charge', 0);
        $payable_currency = Session::get('payable_currency');
        $paid_amount = Session::get('paid_amount', 0);
        $payment_details = Session::get('payment_details');
        $gateway_charge = Session::get('gateway_charge_in_usd', 0);
        $coupon_code = Session::get('coupon_code');
        $offer_percentage = Session::get('offer_percentage', 0);
        $coupon_discount_amount = Session::get('coupon_discount_amount', 0);

        $user = userAuth(); // Assuming userAuth() returns the authenticated user

        // Create the Order record in the database
        $order = Order::create([
            'user_id' => $user->id,
            'buyer_id' => $user->id, // Explicitly set buyer_id
            'order_number' => uniqid(), // Or use $orderId if it's meant to be the order number
            'invoice_id' => $orderId, // Store Midtrans order ID as invoice_id
            'payable_amount' => $grossAmount,
            'payable_with_charge' => $payable_with_charge,
            'payable_currency' => $payable_currency,
            'gateway_name' => 'Midtrans', // Assuming this is for Midtrans
            'transaction_id' => $orderId, // Use Midtrans order ID as transaction_id
            'payment_status' => 'pending', // Initial status
            'paid_amount' => $paid_amount,
            'payment_details' => json_encode($payment_details),
            'gateway_charge' => $gateway_charge,
            'status' => 'pending', // Initial status
            'has_coupon' => Session::has('coupon_code') ? 1 : 0,
            'coupon_code' => $coupon_code,
            'coupon_discount_percent' => $offer_percentage,
            'coupon_discount_amount' => $coupon_discount_amount,
            'payment_method' => 'Midtrans', // Assuming this is for Midtrans
            'conversion_rate' => 1, // Assuming 1 for now, adjust if multi-currency conversion is needed here
            'commission_rate' => Cache::get('setting')->commission_rate, // Assuming commission_rate is available
        ]);

        // Process cart items, create OrderItems, Enrollments, and handle instructor commission
        foreach (Cart::content() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'price' => $item->price,
                'course_id' => $item->id,
                'commission_rate' => Cache::get('setting')->commission_rate,
            ]);

            Enrollment::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'course_id' => $item->id,
                'has_access' => 1,
            ]);

            // insert instructor commission to his wallet
            $commissionAmount = $item->price * ($order->commission_rate / 100);
            $amountAfterCommission = $item->price - $commissionAmount;  
            $instructor = Course::find($item->id)->instructor;
            if ($instructor) { // Check if instructor exists
                $instructor->increment('wallet_balance', $amountAfterCommission);
            }
        }

        Cart::destroy(); // Clear the cart after processing items

        // Prepare transaction details for Midtrans
        $customerDetails = [
            'first_name' => $user->name ?? 'Guest',
            'email' => $user->email ?? 'guest@example.com',
        ];

        $itemDetails = [
            [
                'id' => 'item-1', // This will be replaced by actual items from OrderItems if needed by Midtrans
                'price' => $grossAmount,
                'quantity' => 1,
                'name' => 'Course/Product Purchase',
            ]
        ];

        // If Midtrans requires detailed item breakdown, you might need to iterate through $order->orderItems
        // and populate $itemDetails accordingly. For now, using grossAmount as total.

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => $grossAmount,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
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
        Cache::put('midtrans_payment', $midtrans_payment);
    }

    public function pay(Order $order)
    {
        // Update order to reflect Midtrans is being used
        $order->update([
            'gateway_name' => 'Midtrans',
            'payment_method' => 'Midtrans',
        ]);

        // Get Midtrans credentials
        $midtrans_info = MidtransSetting::get();
        $midtrans_payment_settings = [];
        foreach ($midtrans_info as $item) {
            $midtrans_payment_settings[$item->key] = $item->value;
        }

        $serverKey = $midtrans_payment_settings['server_key'] ?? '';
        $clientKey = $midtrans_payment_settings['client_key'] ?? '';
        $isProduction = filter_var($midtrans_payment_settings['is_production'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Set Midtrans configuration
        Config::$serverKey = $serverKey;
        Config::$isProduction = $isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Prepare transaction details from the order
        $user = $order->user;
        $transactionDetails = [
            'order_id' => $order->invoice_id, // Use the existing invoice_id from the order
            'gross_amount' => $order->payable_amount,
        ];

        $itemDetails = [];
        foreach ($order->orderItems as $item) {
            $itemDetails[] = [
                'id' => $item->course_id,
                'price' => $item->price,
                'quantity' => 1,
                'name' => $item->course->title, // Assuming course relationship exists and has a title
            ];
        }

        $customerDetails = [
            'first_name' => $user->name ?? 'Guest',
            'email' => $user->email ?? 'guest@example.com',
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            // Handle exception, maybe redirect back with an error
            return redirect()->route('checkout.index')->with(['messege' => $e->getMessage(), 'alert-type' => 'error']);
        }

        return view('midtrans::pay', [
            'snap_token' => $snapToken,
            'client_key' => $clientKey,
            'is_production' => $isProduction,
            'order' => $order,
        ]);
    }
}
