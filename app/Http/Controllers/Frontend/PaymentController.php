<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\BankInformationRequest;
use App\Jobs\DefaultMailJob;
use App\Mail\DefaultMail;
use App\Models\Course;
use App\Traits\GetGlobalInformationTrait;
use App\Traits\MailSenderTrait;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Modules\BasicPayment\app\Enums\BasicPaymentSupportedCurrenyListEnum;
use Modules\BasicPayment\app\Http\Controllers\FrontPaymentController;
use Modules\ClubPoint\app\Models\ClubPointHistory;
use Modules\Coupon\app\Models\Coupon;
use Modules\Coupon\app\Models\CouponHistory;
use Modules\Currency\app\Models\MultiCurrency;
use Modules\GlobalSetting\app\Models\EmailTemplate;
use Modules\Order\app\Models\Enrollment;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Modules\PaymentGateway\app\Enums\PaymentGatewaySupportedCurrenyListEnum;
use Modules\PaymentGateway\app\Http\Controllers\AddonPaymentController;
use Str;

class PaymentController extends Controller
{
    use GetGlobalInformationTrait, MailSenderTrait;

    public function payment_addon_success($bankDetails = null)
    {
        Log::info('payment_addon_success called. Session current_order_id: ' . Session::get('current_order_id'));

        $payable_amount = Session::get('payable_amount');
        $payable_with_charge = Session::get('payable_with_charge', 0);
        $payable_currency = Session::get('payable_currency');
        $gateway_name = Session::get('after_success_gateway');
        $transaction = Session::get('after_success_transaction');
        $paid_amount = Session::get('paid_amount', 0);
        $paymentDetails = Session::get('payment_details');
        $gateway_charge = Session::get('gateway_charge');

        if (in_array($gateway_name, ['Razorpay', 'Stripe'])) {
            $allCurrencyCodes = BasicPaymentSupportedCurrenyListEnum::getStripeSupportedCurrencies();

            if (in_array(Str::upper($payable_currency), $allCurrencyCodes['non_zero_currency_codes'])) {
                $paid_amount = $paid_amount;
            } elseif (in_array(Str::upper($payable_currency), $allCurrencyCodes['three_digit_currency_codes'])) {
                $paid_amount = (int) rtrim(strval($paid_amount), '0');
            } else {
                $paid_amount = floatval($paid_amount / 100);
            }
        }

        $user = userAuth();

        // Retrieve the existing order
        $order_id = Session::get('current_order_id');
        $order = Order::find($order_id);

        Log::info('Order found: ' . ($order ? $order->id : 'null'));

        if (!$order) {
            // Handle case where order is not found (e.g., session expired, direct access)
            $notification = trans('Order not found or session expired.');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            return redirect()->route('order-fail')->with($notification);
        }

        // Update the existing order
        $order->update([
            'status' => 'completed',
            'payment_method' => $gateway_name,
            'payment_status' => 'paid',
            'payable_amount' => $payable_amount,
            'gateway_charge' => $gateway_charge,
            'payable_with_charge' => $payable_with_charge,
            'paid_amount' => $paid_amount,
            'payable_currency' => $payable_currency,
            'conversion_rate' => Session::get('currency_rate', 1),
            'payment_details' => json_encode($paymentDetails),
            'transaction_id' => $transaction,
        ]);

        Log::info('Order updated to: status=' . $order->status . ', payment_status=' . $order->payment_status);

        $data_layer_order_items = [];

        foreach (Cart::content() as $item) {
            $order_item = [
                'order_id' => $order->id,
                'price' => $item->price,
                'course_id' => $item->id,
                'commission_rate' => Cache::get('setting')->commission_rate,
            ];
            // OrderItem is already created in createTransaction, no need to create again
            // OrderItem::create([
            //     'order_id' => $order->id,
            //     'price' => $item->price,
            //     'course_id' => $item->id,
            //     'commission_rate' => Cache::get('setting')->commission_rate,
            // ]);
            $data_layer_order_items[] = [
                'course_name' => $item->name,
                'price' => currency($item->price),
                'url' => route('course.show', $item->options->slug),
            ];
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
            $instructor->increment('wallet_balance', $amountAfterCommission);
            
        }
        $settings = cache()->get('setting');
        $marketingSettings = cache()->get('marketing_setting');
        if ($user && $settings->google_tagmanager_status == 'active' && $marketingSettings->order_success) {
            $order_success = [
                'invoice_id' => $order->invoice_id,
                'transaction_id' => $order->transaction_id,
                'payment_method' => $order->payment_method,
                'payable_currency' => $order->payable_currency,
                'paid_amount' => $order->paid_amount,
                'payment_status' => $order->payment_status,
                'order_items' => $data_layer_order_items,
                'student_info' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ];
            session()->put('enrollSuccess', $order_success);
        }

        // send mail

        $this->handleMailSending([
            'email' => $user->email,
            'name' => $user->name,
            'order_id' => $order->invoice_id,
            'paid_amount' => $order->paid_amount. ' '.$order->payable_currency,
            'payment_method' => $order->payment_method
        ]);

        Session::forget([
            'after_success_url',
            'after_faild_url',
            'payable_amount',
            'gateway_charge',
            'after_success_gateway',
            'after_success_transaction',
            'subscription_plan_id',
            'payable_with_charge',
            'payable_currency',
            'subscription_plan_id',
            'paid_amount',
            'payment_details',
            'coupon_code',
            'offer_percentage',
            'coupon_discount_amount',
            'gateway_charge_in_usd',
            'current_order_id' // Forget the stored order ID
        ]);

        $notification = trans('Payment Success.');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('order-success')->with($notification);
    }

    private function _processSuccessfulPayment(
        Order $order, // Changed signature to accept Order object
        $gateway_name,
        $transaction,
        $paymentDetails
    ) {
        $user = userAuth(); // User is already associated with the order

        // Ensure order status is completed and paid
        $order->payment_status = 'paid';
        $order->status = 'completed';
        $order->save();

        // OrderItems, Enrollments, and Cart::destroy() are now handled in MidtransController::createTransaction

        $settings = cache()->get('setting');
        $marketingSettings = cache()->get('marketing_setting');
        if ($user && $settings->google_tagmanager_status == 'active' && $marketingSettings->order_success) {
            // Populate data_layer_order_items from $order->orderItems relationship
            $data_layer_order_items = [];
            foreach ($order->orderItems as $item) {
                $data_layer_order_items[] = [
                    'course_name' => $item->course->title ?? 'N/A', // Assuming Course model has title
                    'price' => currency($item->price),
                    'url' => route('course.show', $item->course->slug ?? 'N/A'), // Assuming Course model has slug
                ];
            }

            $order_success = [
                'invoice_id' => $order->invoice_id,
                'transaction_id' => $order->transaction_id,
                'payment_method' => $order->payment_method,
                'payable_currency' => $order->payable_currency,
                'paid_amount' => $order->paid_amount,
                'payment_status' => $order->payment_status,
                'order_items' => $data_layer_order_items,
                'student_info' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ];
            session()->put('enrollSuccess', $order_success);
        }

        // send mail

        $this->handleMailSending([
            'email' => $user->email,
            'name' => $user->name,
            'order_id' => $order->invoice_id,
            'paid_amount' => $order->paid_amount. ' '.$order->payable_currency,
            'payment_method' => $order->payment_method
        ]);
    }

    public function payment_addon_faild()
    {
        $order_id = Session::get('current_order_id');
        $order = Order::find($order_id);

        if ($order) {
            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed',
            ]);
        }

        $data_layer_order_items = [];
        foreach (Cart::content() as $item) {
            $data_layer_order_items[] = [
                'course_name' => $item->name,
                'price' => currency($item->price),
                'url' => route('course.show', $item->options->slug),
            ];
        }
        
        $settings = cache()->get('setting');
        $marketingSettings = cache()->get('marketing_setting');
        if ($settings->google_tagmanager_status == 'active' && $marketingSettings->order_failed) {
            $user = userAuth();
            $order_failed = [
                'payable_currency' => session('payable_currency',getSessionCurrency()),
                'paid_amount' => session('paid_amount' , null),
                'payment_status' => 'Failed',
                'order_items' => $data_layer_order_items,
                'student_info' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ];
            session()->put('enrollFailed', $order_failed);
        }
        Session::forget([
            'after_success_url',
            'after_faild_url',
            'payable_amount',
            'gateway_charge',
            'after_success_gateway',
            'after_success_transaction',
            'subscription_plan_id',
            'payable_with_charge',
            'payable_currency',
            'subscription_plan_id',
            'paid_amount',
            'payment_details',
            'cart',
            'coupon_code',
            'offer_percentage',
            'coupon_discount_amount',
            'gateway_charge_in_usd',
            'current_order_id' // Forget the stored order ID
        ]);

        $notification = trans('Payment faild, please try again');
        $notification = ['messege' => $notification, 'alert-type' => 'error'];

        return redirect()->route('order-fail')->with($notification);
    }

    public function midtransCallbackSuccess(Request $request)
    {
        Log::info('Midtrans Callback Received. Request data: ' . json_encode($request->all()));

        $midtrans_info = \Modules\Midtrans\app\Models\MidtransSetting::get();
        $midtrans_payment_settings = [];
        foreach ($midtrans_info as $item) {
            $midtrans_payment_settings[$item->key] = $item->value;
        }

        \Midtrans\Config::$serverKey = $midtrans_payment_settings['server_key'] ?? '';
        \Midtrans\Config::$isProduction = filter_var($midtrans_payment_settings['is_production'] ?? false, FILTER_VALIDATE_BOOLEAN);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $transaction_status = null;
        $fraud_status = null;
        $transaction_id = null;
        $order_id = null;
        $gross_amount = null;
        $payment_type = null;

        try {
            $notif = new \Midtrans\Notification();
            Log::info('Midtrans Notification Object: ' . json_encode($notif));
            $transaction_status = $notif->transaction_status;
            $fraud_status = $notif->fraud_status;
            $transaction_id = $notif->transaction_id;
            $order_id = $notif->order_id; // This is the invoice_id from our Order
            $gross_amount = $notif->gross_amount;
            $payment_type = $notif->payment_type;

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            $notification = trans('Payment verification failed.');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            return redirect()->route('order-fail')->with($notification);
        }

        Log::info('Transaction Status: ' . $transaction_status . ', Fraud Status: ' . $fraud_status);

        if ($transaction_status == 'capture') {
            if ($fraud_status == 'challenge') {
                Session::put('after_success_gateway', 'Midtrans');
                Session::put('after_success_transaction', $transaction_id);
                Session::put('paid_amount', $gross_amount);
                Session::put('payable_currency', getSessionCurrency());
                Session::put('payable_amount', $notif->gross_amount); // Set payable_amount from Midtrans notification
                Session::put('gateway_charge', 0); // Assuming 0 for Midtrans unless specified
                Session::put('payment_details', [
                    'transaction_status' => $transaction_status,
                    'fraud_status' => $fraud_status,
                    'payment_type' => $payment_type,
                    'gross_amount' => $notif->gross_amount,
                    'currency' => $notif->currency,
                    'transaction_time' => $notif->transaction_time,
                    'settlement_time' => $notif->settlement_time ?? null,
                    'va_numbers' => $notif->va_numbers ?? null,
                    'bill_key' => $notif->bill_key ?? null,
                    'bill_code' => $notif->bill_code ?? null,
                    'pdf_url' => $notif->pdf_url ?? null,
                ]);
                Log::info('Session data set (capture/challenge): after_success_gateway=' . Session::get('after_success_gateway') . ', transaction=' . Session::get('after_success_transaction') . ', paid_amount=' . Session::get('paid_amount'));
                return redirect()->route('payment-addon-success');
            } else if ($fraud_status == 'accept') {
                Session::put('after_success_gateway', 'Midtrans');
                Session::put('after_success_transaction', $transaction_id);
                Session::put('paid_amount', $gross_amount);
                Session::put('payable_currency', getSessionCurrency());
                Session::put('payable_amount', $notif->gross_amount); // Set payable_amount from Midtrans notification
                Session::put('gateway_charge', 0); // Assuming 0 for Midtrans unless specified
                Session::put('payment_details', [
                    'transaction_status' => $transaction_status,
                    'fraud_status' => $fraud_status,
                    'payment_type' => $payment_type,
                    'gross_amount' => $notif->gross_amount,
                    'currency' => $notif->currency,
                    'transaction_time' => $notif->transaction_time,
                    'settlement_time' => $notif->settlement_time ?? null,
                    'va_numbers' => $notif->va_numbers ?? null,
                    'bill_key' => $notif->bill_key ?? null,
                    'bill_code' => $notif->bill_code ?? null,
                    'pdf_url' => $notif->pdf_url ?? null,
                ]);
                Log::info('Session data set (capture/accept): after_success_gateway=' . Session::get('after_success_gateway') . ', transaction=' . Session::get('after_success_transaction') . ', paid_amount=' . Session::get('paid_amount'));
                return redirect()->route('payment-addon-success');
            }
        } else if ($transaction_status == 'settlement') {
            Session::put('after_success_gateway', 'Midtrans');
            Session::put('after_success_transaction', $transaction_id);
            Session::put('paid_amount', $gross_amount);
            Session::put('payable_currency', getSessionCurrency());
            Session::put('payable_amount', $notif->gross_amount); // Set payable_amount from Midtrans notification
            Session::put('gateway_charge', 0); // Assuming 0 for Midtrans unless specified
            Session::put('payment_details', [
                'transaction_status' => $transaction_status,
                'fraud_status' => $fraud_status,
                'payment_type' => $payment_type,
                'gross_amount' => $notif->gross_amount,
                'currency' => $notif->currency,
                'transaction_time' => $notif->transaction_time,
                'settlement_time' => $notif->settlement_time ?? null,
                'va_numbers' => $notif->va_numbers ?? null,
                'bill_key' => $notif->bill_key ?? null,
                'bill_code' => $notif->bill_code ?? null,
                'pdf_url' => $notif->pdf_url ?? null,
            ]);
            Log::info('Session data set (settlement): after_success_gateway=' . Session::get('after_success_gateway') . ', transaction=' . Session::get('after_success_transaction') . ', paid_amount=' . Session::get('paid_amount'));
            return redirect()->route('payment-addon-success');
        } else if ($transaction_status == 'pending') {
            $notification = trans('Payment is pending. Please complete the payment.');
            $notification = ['messege' => $notification, 'alert-type' => 'warning'];
            Log::info('Session data set (pending): after_success_gateway=' . Session::get('after_success_gateway') . ', transaction=' . Session::get('after_success_transaction') . ', paid_amount=' . Session::get('paid_amount'));
            return redirect()->route('order-unfinish')->with($notification);
        } else if ($transaction_status == 'deny') {
            $notification = trans('Payment denied.');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            Log::info('Session data set (deny): after_success_gateway=' . Session::get('after_success_gateway') . ', transaction=' . Session::get('after_success_transaction') . ', paid_amount=' . Session::get('paid_amount'));
            return redirect()->route('order-fail')->with($notification);
        } else if ($transaction_status == 'expire') {
            $notification = trans('Payment expired.');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            Log::info('Session data set (expire): after_success_gateway=' . Session::get('after_success_gateway') . ', transaction=' . Session::get('after_success_transaction') . ', paid_amount=' . Session::get('paid_amount'));
            return redirect()->route('order-fail')->with($notification);
        } else if ($transaction_status == 'cancel') {
            $notification = trans('Payment cancelled.');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            Log::info('Session data set (cancel): after_success_gateway=' . Session::get('after_success_gateway') . ', transaction=' . Session::get('after_success_transaction') . ', paid_amount=' . Session::get('paid_amount'));
            return redirect()->route('order-fail')->with($notification);
        }

        $notification = trans('Payment status unknown.');
        $notification = ['messege' => $notification, 'alert-type' => 'error'];
        Log::info('Session data set (unknown): after_success_gateway=' . Session::get('after_success_gateway') . ', transaction=' . Session::get('after_success_transaction') . ', paid_amount=' . Session::get('paid_amount'));
        return redirect()->route('order-fail')->with($notification);
    }

    function order_success() {
       return view('frontend.pages.order-success'); 
    }

    function order_fail() {
       return view('frontend.pages.order-fail'); 
    }

    function order_unfinish() {
       return view('frontend.pages.order-unfinish'); 
    }

    function handleMailSending(array $mailData)
    {
        self::setMailConfig();

        // Get email template
        $template = EmailTemplate::where('name', 'order_completed')->firstOrFail();
        $mailData['subject'] = $template->subject;

        // Prepare email content
        $message = str_replace('{{name}}', $mailData['name'], $template->message);
        $message = str_replace('{{order_id}}', $mailData['order_id'], $message);
        $message = str_replace('{{paid_amount}}', $mailData['paid_amount'], $message);
        $message = str_replace('{{payment_method}}', $mailData['payment_method'], $message);

        if (self::isQueable()) {
            DefaultMailJob::dispatch($mailData['email'], $mailData, $message);
        } else {
            Mail::to($mailData['email'])->send(new DefaultMail($mailData, $message));
        }
    }
}
