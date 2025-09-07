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
use App\Models\User;

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
        $invoiceId = 'INV-' . strtoupper(Str::random(10));

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
                'order_id' => $invoiceId,
                'gross_amount' => $payable_amount,
            ],
            'customer_details' => [
                'first_name' => $user->name ?? 'Guest',
                'email' => $user->email ?? 'guest@example.com',
            ],
            'item_details' => $itemDetails,
        ];

        try {
            // Create the Order
            $order = Order::create([
                'invoice_id' => $invoiceId,
                'buyer_id' => $user->id,
                'status' => 'pending',
                'has_coupon' => Session::has('coupon_code') ? 1 : 0,
                'coupon_code' => Session::get('coupon_code'),
                'coupon_discount_percent' => Session::get('offer_percentage'),
                'coupon_discount_amount' => Session::get('coupon_discount_amount'),
                'payment_method' => '-',
                'payment_status' => 'pending',
                'payable_amount' => $payable_amount,
                'gateway_charge' => 0,
                'payable_with_charge' => $payable_amount,
                'paid_amount' => 0,
                'conversion_rate' => 1,
                'payable_currency' => getSessionCurrency(),
                'payment_details' => null,
                'transaction_id' => null,
                'commission_rate' => Cache::get('setting')->commission_rate,
            ]);

            // Create OrderItems
            foreach (Cart::content() as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'price' => $cartItem->price,
                    'course_id' => $cartItem->id,
                    'commission_rate' => $order->commission_rate,
                ]);
            }

            $snapToken = Snap::getSnapToken($params);

            // If Snap Token is successfully created, clear the cart and store pending order id
            Cart::destroy();
            Session::put('pending_order_id', $order->invoice_id);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            // Clean up the created order if Snap token generation fails
            if (isset($order) && $order->exists) {
                $order->update(['status' => 'failed', 'payment_status' => 'failed']);
            }
            Cart::destroy(); // Clear cart on error
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
            // Even if status check fails, we can check our own DB, as the webhook might have already processed it.
            $order = Order::where('invoice_id', $orderId)->first();
            if ($order && $order->payment_status === 'paid') {
                Cart::destroy();
                return redirect()->route('order-success')->with(['messege' => __('Payment successful! Your order has been placed.'), 'alert-type' => 'success']);
            }
            return redirect()->route('order-fail')->with(['messege' => __('Payment verification failed.'), 'alert-type' => 'error']);
        }

        $isSuccess = false;
        if (isset($status->transaction_status)) {
            if (($status->transaction_status == 'capture' && $status->fraud_status == 'accept') || $status->transaction_status == 'settlement') {
                $isSuccess = true;
            }
        }

        // Clean up session and cart regardless of what our DB says, as long as Midtrans says it's a success.
        if ($isSuccess) {
            Cart::destroy();
            Session::forget('coupon_code');
            Session::forget('offer_percentage');
            Session::forget('coupon_discount_amount');
            Session::forget('payable_amount');
            Session::forget('pending_order_id');
            
            $notification = ['messege' => __('Payment successful! Your order has been placed.'), 'alert-type' => 'success'];
            return redirect()->route('order-success')->with($notification);

        } else {
            Log::warning("Finalize attempt for a non-successful transaction: $orderId. Status: " . ($status->transaction_status ?? 'N/A'));
            return redirect()->route('order-fail')->with(['messege' => __('Payment was not successful.'), 'alert-type' => 'error']);
        }
    }

    public function notify(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans notification received: ' . json_encode($payload));

        // 1. Get Midtrans server key from the config loaded in constructor
        $serverKey = Config::$serverKey;

        // 2. Get data from payload
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;

        // 3. Verify signature
        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
            Log::error('Midtrans notification: Missing required fields.');
            return response('Invalid payload', 400);
        }
        
        $expectedSignatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if ($signatureKey !== $expectedSignatureKey) {
            Log::error("Midtrans notification signature mismatch for order_id: $orderId");
            return response('Invalid signature', 403);
        }

        // 4. Find the order
        $order = Order::where('invoice_id', $orderId)->first();
        if (!$order) {
            Log::error("Midtrans notification: Order with invoice_id $orderId not found.");
            return response('Order not found', 404);
        }

        // 5. Check for duplicate processing
        if ($order->payment_status === 'paid') {
            Log::warning("Midtrans notification: Order $orderId already processed.");
            return response('Order already processed', 200);
        }

        // 6. Handle transaction status
        $isSuccess = false;
        if ($transactionStatus == 'capture' && ($payload['fraud_status'] ?? '') == 'accept') {
            $isSuccess = true;
        } elseif ($transactionStatus == 'settlement') {
            $isSuccess = true;
        }

        if ($isSuccess) {
            // 7a. Update Order
            $order->payment_status = 'paid';
            $order->status = 'completed';
            $order->transaction_id = $payload['transaction_id'];
            $order->paid_amount = $payload['gross_amount'];
            $order->payment_details = json_encode($payload);
            
            $paymentType = $payload['payment_type'] ?? 'midtrans';
            $order->payment_method = match ($paymentType) {
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
            
            $order->save();

            // 7b. Create Enrollment & Pay Instructor
            foreach ($order->orderItems as $item) {
                // Check if enrollment already exists to be idempotent
                Enrollment::firstOrCreate(
                    ['user_id' => $order->buyer_id, 'course_id' => $item->course_id],
                    ['order_id' => $order->id, 'has_access' => 1]
                );

                $instructor = Course::find($item->course_id)->instructor;
                if ($instructor) {
                    $commissionAmount = $item->price * ($order->commission_rate / 100);
                    $amountAfterCommission = $item->price - $commissionAmount;
                    // To make this idempotent, we should check if the wallet has already been credited for this order.
                    // For simplicity, we assume the duplicate check at the start is enough.
                    $instructor->increment('wallet_balance', $amountAfterCommission);
                }
            }

            // 7c. Send Email
            $user = User::find($order->buyer_id);
            if ($user) {
                $this->handleMailSending([
                    'email' => $user->email,
                    'name' => $user->name,
                    'order_id' => $order->invoice_id,
                    'paid_amount' => currency($order->paid_amount),
                    'payment_method' => $order->payment_method
                ]);
            }

        } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'])) {
            // Handle failed statuses
            $order->payment_status = $transactionStatus;
            $order->status = 'failed';
            $order->save();
            Log::info("Midtrans notification: Order {$order->invoice_id} status updated to $transactionStatus.");
        }

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

    public function retryPayment(Request $request, $invoice_id = null)
    {
        // The invoice_id from the URL takes precedence. 
        // If it's null, fall back to the one stored in the session from the initial failed attempt.
        $orderId = $invoice_id ?? Session::get('pending_order_id');

        if (!$orderId) {
            // This happens if the session expires and they try to access the generic retry URL
            return redirect()->route('student.orders.index')->with(['messege' => __('No pending order found to retry.'), 'alert-type' => 'error']);
        }

        $order = Order::where('invoice_id', $orderId)
                        ->where('payment_status', 'pending')
                        ->first();

        if (!$order) {
            return redirect()->route('student.orders.index')->with(['messege' => __('Pending order not found or already paid.'), 'alert-type' => 'error']);
        }

        // Security Check: Ensure the authenticated user owns this order
        if ($order->buyer_id !== Auth::id()) {
            return redirect()->route('student.orders.index')->with(['messege' => __('You are not authorized to pay for this order.'), 'alert-type' => 'error']);
        }

        $user = User::find($order->buyer_id);

        $itemDetails = [];
        foreach ($order->orderItems as $item) {
            $courseTitle = $item->course->title ?? 'Course'; 
            $itemDetails[] = [
                'id' => $item->course_id,
                'price' => $item->price,
                'quantity' => 1,
                'name' => $courseTitle,
            ];
        }

        if ($order->has_coupon) {
            $itemDetails[] = [
                'id' => 'COUPON_' . $order->coupon_code,
                'price' => -(int)$order->coupon_discount_amount,
                'quantity' => 1,
                'name' => 'Coupon Discount'
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_id,
                'gross_amount' => $order->payable_amount,
            ],
            'customer_details' => [
                'first_name' => $user->name ?? 'Guest',
                'email' => $user->email ?? 'guest@example.com',
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $midtrans_info = MidtransSetting::get();
            $midtrans_payment_settings = [];
            foreach ($midtrans_info as $item) {
                $midtrans_payment_settings[$item->key] = $item->value;
            }
            $midtrans_credentials = (object) [
                'client_key' => $midtrans_payment_settings['client_key'] ?? '',
                'is_production' => filter_var($midtrans_payment_settings['is_production'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ];

            return view('midtrans::retry-payment', [
                'snap_token' => $snapToken,
                'midtrans_credentials' => $midtrans_credentials,
                'invoice_id' => $order->invoice_id
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error on retry: ' . $e->getMessage());
            return redirect()->route('student.orders.index')->with(['messege' => __('Failed to create payment token. Please try again.'), 'alert-type' => 'error']);
        }
    }
}