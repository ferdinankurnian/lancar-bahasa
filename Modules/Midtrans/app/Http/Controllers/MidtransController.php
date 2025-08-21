<?php

namespace Modules\Midtrans\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Midtrans\app\Models\MidtransSetting;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\Course;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Modules\Order\app\Models\Enrollment;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Traits\MailSenderTrait;
use Modules\GlobalSetting\app\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\DefaultMail;
use App\Jobs\DefaultMailJob;

class MidtransController extends Controller
{
    use MailSenderTrait;

    public function __construct()
    {
        // Set Midtrans configuration for all methods in this controller
        $midtrans_payment_settings = Cache::get('midtrans_payment');
        if (!$midtrans_payment_settings) {
            $this->put_midtrans_payment_cache();
            $midtrans_payment_settings = Cache::get('midtrans_payment');
        }

        if ($midtrans_payment_settings) {
            Config::$serverKey = $midtrans_payment_settings->server_key ?? '';
            Config::$isProduction = filter_var($midtrans_payment_settings->is_production ?? false, FILTER_VALIDATE_BOOLEAN);
            Config::$isSanitized = true;
            Config::$is3ds = true;
        }
    }

    public function index()
    {
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

    public function createTransaction(Request $request)
    {
        $user = Auth::user();
        $payable_amount = Session::get('payable_amount', (int) Cart::total(2, '.', ''));
        $paymentAttemptId = 'INV-' . strtoupper(Str::random(10));

        $paymentData = [
            'cart_content' => Cart::content(),
            'cart_total' => Cart::total(2, '.', ''),
            'payable_amount' => $payable_amount,
            'has_coupon' => Session::has('coupon_code') ? 1 : 0,
            'coupon_code' => Session::get('coupon_code'),
            'offer_percentage' => Session::get('offer_percentage'),
            'coupon_discount_amount' => Session::get('coupon_discount_amount'),
            'payable_currency' => getSessionCurrency(),
            'commission_rate' => Cache::get('setting')->commission_rate,
            'user_id' => $user->id,
        ];

        Session::put('midtrans_payment_attempt_' . $paymentAttemptId, $paymentData);

        $itemDetails = [];
        foreach (Cart::content() as $item) {
            $itemDetails[] = [
                'id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->qty,
                'name' => $item->name,
            ];
        }

        if (Session::has('coupon_code')) {
            $itemDetails[] = [
                'id' => 'COUPON_' . Session::get('coupon_code'),
                'price' => -(int)Session::get('coupon_discount_amount'),
                'quantity' => 1,
                'name' => 'Coupon Discount'
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $paymentAttemptId,
                'gross_amount' => $payable_amount,
            ],
            'customer_details' => [
                'first_name' => $user->name ?? 'Guest',
                'email' => $user->email ?? 'guest@example.com',
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create payment token.'], 500);
        }
    }

    public function finalizeTransaction(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            Log::warning('Midtrans finalize attempt without order_id.');
            return redirect()->route('order-fail')->with(['messege' => __('Invalid payment request.'), 'alert-type' => 'error']);
        }

        try {
            $status = Transaction::status($orderId);
        } catch (\Exception $e) {
            Log::error("Midtrans status check failed for order_id $orderId: " . $e->getMessage());
            return redirect()->route('order-fail')->with(['messege' => __('Payment verification failed.'), 'alert-type' => 'error']);
        }

        $isSuccess = false;
        if (isset($status->transaction_status)) {
            if ($status->transaction_status == 'capture' && $status->fraud_status == 'accept') {
                $isSuccess = true;
            } elseif ($status->transaction_status == 'settlement') {
                $isSuccess = true;
            }
        }

        if ($isSuccess) {
            // Prevent duplicate processing
            if (Order::where('invoice_id', $orderId)->exists()) {
                Log::warning("Finalize attempt for an already processed order: $orderId");
                Cart::destroy(); // Still destroy the cart
                return redirect()->route('order-success');
            }

            $paymentData = Session::get('midtrans_payment_attempt_' . $orderId);

            if (!$paymentData) {
                Log::error("Session data for order_id $orderId not found during finalize.");
                return redirect()->route('order-fail')->with(['messege' => __('Your session has expired. Please try again.'), 'alert-type' => 'error']);
            }

            $user = Auth::loginUsingId($paymentData['user_id']);

            // Get specific payment method name
            $paymentType = $status->payment_type ?? 'midtrans';
            $paymentMethodName = match ($paymentType) {
                'credit_card' => 'Credit Card',
                'gopay' => 'GoPay',
                'shopeepay' => 'ShopeePay',
                'qris' => 'QRIS',
                'bca_va' => 'BCA Virtual Account',
                'bni_va' => 'BNI Virtual Account',
                'bri_va' => 'BRI Virtual Account',
                'echannel' => 'Mandiri Bill',
                'other_va' => 'Other Virtual Account',
                'akulaku' => 'Akulaku',
                'alfamart' => 'Alfamart',
                'indomaret' => 'Indomaret',
                default => ucwords(str_replace('_', ' ', $paymentType)),
            };

            $order = Order::create([
                'invoice_id' => $orderId,
                'buyer_id' => $paymentData['user_id'],
                'status' => 'completed',
                'has_coupon' => $paymentData['has_coupon'],
                'coupon_code' => $paymentData['coupon_code'],
                'coupon_discount_percent' => $paymentData['offer_percentage'],
                'coupon_discount_amount' => $paymentData['coupon_discount_amount'],
                'payment_method' => $paymentMethodName, // Use the dynamic payment method name
                'payment_status' => 'paid',
                'payable_amount' => $paymentData['payable_amount'],
                'gateway_charge' => 0,
                'payable_with_charge' => $paymentData['payable_amount'],
                'paid_amount' => $status->gross_amount,
                'conversion_rate' => 1,
                'payable_currency' => $paymentData['payable_currency'],
                'payment_details' => json_encode($status),
                'transaction_id' => $status->transaction_id,
                'commission_rate' => $paymentData['commission_rate'],
            ]);

            foreach ($paymentData['cart_content'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'price' => $item->price,
                    'course_id' => $item->id,
                    'commission_rate' => $paymentData['commission_rate'],
                ]);
                Enrollment::create([
                    'order_id' => $order->id,
                    'user_id' => $paymentData['user_id'],
                    'course_id' => $item->id,
                    'has_access' => 1,
                ]);
                $instructor = Course::find($item->id)->instructor;
                if ($instructor) {
                    $commissionAmount = $item->price * ($order->commission_rate / 100);
                    $amountAfterCommission = $item->price - $commissionAmount;
                    $instructor->increment('wallet_balance', $amountAfterCommission);
                }
            }

            $this->handleMailSending([
                'email' => $user->email,
                'name' => $user->name,
                'order_id' => $order->invoice_id,
                'paid_amount' => $order->paid_amount . ' ' . $order->payable_currency,
                'payment_method' => $order->payment_method
            ]);

            Cart::destroy();
            // Clean up all session data related to the transaction
            Session::forget('midtrans_payment_attempt_' . $orderId);
            Session::forget('coupon_code');
            Session::forget('offer_percentage');
            Session::forget('coupon_discount_amount');
            Session::forget('payable_amount');
            
            $notification = ['messege' => __('Payment successful! Your order has been placed.'), 'alert-type' => 'success'];
            return redirect()->route('order-success')->with($notification);

        } else {
            Log::warning("Finalize attempt for a non-successful transaction: $orderId. Status: " . ($status->transaction_status ?? 'N/A'));
            return redirect()->route('order-fail')->with(['messege' => __('Payment was not successful.'), 'alert-type' => 'error']);
        }
    }

    public function notify(Request $request)
    {
        // This webhook now serves as a secondary confirmation or for backend status updates.
        // The primary order creation logic is in finalizeTransaction to ensure it happens within the user's session.
        Log::info('Midtrans notification received: ' . json_encode($request->all()));
        // Optional: You could add logic here to update an order's status to 'webhook_confirmed',
        // but for now, we will keep it simple and just log the notification.
        return response('OK', 200);
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

    private function handleMailSending(array $mailData)
    {
        try {
            self::setMailConfig();
            $template = EmailTemplate::where('name', 'order_completed')->first();
            if (!$template) {
                Log::error('Order completed email template not found.');
                return;
            }
            $mailData['subject'] = $template->subject;
            $message = str_replace(
                ['{{name}}', '{{order_id}}', '{{paid_amount}}', '{{payment_method}}'],
                [$mailData['name'], $mailData['order_id'], $mailData['paid_amount'], $mailData['payment_method']],
                $template->message
            );

            if (self::isQueable()) {
                DefaultMailJob::dispatch($mailData['email'], $mailData, $message);
            } else {
                Mail::to($mailData['email'])->send(new DefaultMail($mailData, $message));
            }
            Log::info('Order completion email sent to ' . $mailData['email']);
        } catch (\Exception $e) {
            Log::error('Failed to send order completion email: ' . $e->getMessage());
        }
    }
}