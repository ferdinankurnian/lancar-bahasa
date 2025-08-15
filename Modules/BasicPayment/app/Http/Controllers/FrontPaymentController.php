<?php

namespace Modules\BasicPayment\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\GetGlobalInformationTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\BasicPayment\app\Enums\BasicPaymentSupportedCurrenyListEnum;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe;

class FrontPaymentController extends Controller
{
    use GetGlobalInformationTrait;

    private $appName = '';

    public function __construct()
    {
        $settings = Cache::has('setting') ? Cache::get('setting') : null;
        if ($settings) {
            $this->appName = $settings->app_name;
        }
        $this->middleware('auth');
    }

    public function pay_with_stripe(Request $request, $stripe_credentials, $payable_amount, $after_success_url, $after_faild_url, $user)
    {
        $rules = [
            'card_number' => 'required|numeric',
            'year' => 'required|numeric|min:2',
            'month' => 'required|numeric|min:2',
            'cvc' => 'required|numeric',
        ];

        $customMessages = [
            'card_number.required' => trans('Card number is required'),
            'year.required' => trans('Year is required'),
            'month.required' => trans('Month is required'),
            'cvc.required' => trans('Cvc is required'),
        ];

        $request->validate($rules, $customMessages);

        Stripe\Stripe::setApiKey($stripe_credentials->stripe_secret);

        if (! $request->filled('stripeToken')) {
            $notification = trans('Payment failed please try again');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

        $calculate_payable_charge = $this->calculate_payable_charge($payable_amount, 'stripe');

        $allCurrencyCodes = BasicPaymentSupportedCurrenyListEnum::getStripeSupportedCurrencies();

        if (in_array(Str::upper($calculate_payable_charge->currency_code), $allCurrencyCodes['non_zero_currency_codes'])) {
            $payable_with_charge = $calculate_payable_charge->payable_with_charge;
        } elseif (in_array(Str::upper($calculate_payable_charge->currency_code), $allCurrencyCodes['three_digit_currency_codes'])) {
            $convertedCharge = (string) $calculate_payable_charge->payable_with_charge.'0';
            $payable_with_charge = (int) $convertedCharge;
        } else {
            $payable_with_charge = (int) ($calculate_payable_charge->payable_with_charge * 100);
        }

        $paymentDetails = null;

        try {
            $result = Stripe\Charge::create([
                'currency' => $calculate_payable_charge->currency_code,
                'amount' => $payable_with_charge,
                'description' => $this->appName,
                'source' => $request->stripeToken,
            ]);

            $paymentDetails = [
                'transaction_id' => $result->balance_transaction,
                'amount' => $result->amount,
                'currency' => $result->currency,
                'paid' => $result->paid,
                'description' => $result->description,
                'seller_message' => $result->outcome->seller_message,
                'payment_method' => $result->payment_method,
                'card_last4_digit' => $result->payment_method_details->card->last4,
                'card_brand' => $result->payment_method_details->card->brand.' - '.$result->payment_method_details->card->country,
                'receipt_url' => $result->receipt_url,
                'status' => $result->status,
            ];

        } catch (\Exception $e) {
            info($e);
            $notification = trans('Payment faild please try again');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

        Session::put('after_success_url', $after_success_url);
        Session::put('after_faild_url', $after_faild_url);
        Session::put('payable_amount', Session::get('payable_amount'));
        Session::put('paid_amount', $result->amount_captured);
        Session::put('after_success_gateway', 'Stripe');
        Session::put('after_success_transaction', $result->balance_transaction);
        Session::put('payment_details', $paymentDetails);
        session()->put('payable_with_charge', $payable_with_charge);

        return redirect($after_success_url);

    }

    public function pay_with_paypal($paypal_credentials, $payable_amount, $after_success_url, $after_faild_url, $user)
    {
        config(['paypal.mode' => $paypal_credentials->paypal_account_mode]);

        if ($paypal_credentials->paypal_account_mode == 'sandbox') {
            config(['paypal.sandbox.client_id' => $paypal_credentials->paypal_client_id]);
            config(['paypal.sandbox.client_secret' => $paypal_credentials->paypal_secret_key]);
        } else {
            config(['paypal.live.client_id' => $paypal_credentials->paypal_client_id]);
            config(['paypal.live.client_secret' => $paypal_credentials->paypal_secret_key]);
            config(['paypal.live.app_id' => $paypal_credentials->paypal_app_id]);
        }

        $calculate_payable_charge = $this->calculate_payable_charge($payable_amount, 'paypal');
        $payable_with_charge = $calculate_payable_charge->payable_with_charge;
        session()->put('payable_with_charge', $payable_with_charge);

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->setCurrency($calculate_payable_charge->currency_code);
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('basicpayment.paypal-success-payment'),
                    'cancel_url' => $after_faild_url,
                ],
                'purchase_units' => [
                    0 => [
                        'amount' => [
                            'currency_code' => $calculate_payable_charge->currency_code,
                            'value' => $payable_with_charge,
                        ],
                    ],
                ],
            ]);
        } catch (Exception $ex) {
            info($ex);
            $notification = $ex->getMessage();
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

        if (isset($response['id']) && $response['id'] != null) {

            Session::put('after_success_url', $after_success_url);
            Session::put('after_faild_url', $after_faild_url);
            Session::put('payable_amount', Session::get('payable_amount'));
            Session::put('paypal_credentials', $paypal_credentials);

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            $notification = trans('Payment faild, please try again');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);

        } else {
            $notification = trans('Payment faild, please try again');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

    }

    public function paypal_success(Request $request)
    {

        $paypal_credentials = Session::get('paypal_credentials');

        config(['paypal.mode' => $paypal_credentials->paypal_account_mode]);

        if ($paypal_credentials->paypal_account_mode == 'sandbox') {
            config(['paypal.sandbox.client_id' => $paypal_credentials->paypal_client_id]);
            config(['paypal.sandbox.client_secret' => $paypal_credentials->paypal_secret_key]);
        } else {
            config(['paypal.live.client_id' => $paypal_credentials->paypal_client_id]);
            config(['paypal.live.client_secret' => $paypal_credentials->paypal_secret_key]);
            config(['paypal.live.app_id' => $paypal_credentials->paypal_app_id]);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            Session::put('after_success_gateway', 'Paypal');
            Session::put('after_success_transaction', $request->PayerID);

            $after_success_url = Session::get('after_success_url');

            $paid_amount = $this->checkArrayIsset($response['purchase_units'][0]['payments']['captures'][0]['amount']['value']);
            Session::put('paid_amount', $paid_amount);

            $details = [
                'payments_captures_id' => $this->checkArrayIsset($response['purchase_units'][0]['payments']['captures'][0]['id']),
                'amount' => $this->checkArrayIsset($response['purchase_units'][0]['payments']['captures'][0]['amount']['value']),
                'currency' => $this->checkArrayIsset($response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code']),
                'paid' => $this->checkArrayIsset($response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['value']),
                'paypal_fee' => $this->checkArrayIsset($response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value']),
                'net_amount' => $this->checkArrayIsset($response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value']),
                'status' => $this->checkArrayIsset($response['purchase_units'][0]['payments']['captures'][0]['status']),
            ];

            Session::put('payment_details', $details);

            return redirect($after_success_url);

        } else {
            $after_faild_url = Session::get('after_faild_url');

            return redirect($after_faild_url);
        }
    }

    private function checkArrayIsset($value)
    {
        return isset($value) ? $value : null;
    }
}
