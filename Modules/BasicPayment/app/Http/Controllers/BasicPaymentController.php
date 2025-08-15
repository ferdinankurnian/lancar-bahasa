<?php

namespace Modules\BasicPayment\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Currency\app\Models\MultiCurrency;
use Modules\BasicPayment\app\Models\BasicPayment;
use Modules\PaymentGateway\app\Models\PaymentGateway;
use Modules\Midtrans\app\Models\MidtransSetting;

class BasicPaymentController extends Controller
{
    public function basicpayment()
    {
        checkAdminHasPermissionAndThrowException('basic.payment.view');
        $payment_info = BasicPayment::get();

        $basic_payment = [];

        foreach ($payment_info as $payment_item) {
            $basic_payment[$payment_item->key] = $payment_item->value;
        }

        $basic_payment = (object) $basic_payment;

        $payment_info = PaymentGateway::get();

        $payment_setting = [];
        foreach ($payment_info as $payment_item) {
            $payment_setting[$payment_item->key] = $payment_item->value;
        }

        $payment_setting = (object) $payment_setting;

        $currencies = MultiCurrency::get();

        // Added for Midtrans
        $midtrans_info = MidtransSetting::get();
        $midtrans_payment = [];
        foreach ($midtrans_info as $payment_item) {
            $midtrans_payment[$payment_item->key] = $payment_item->value;
        }
        $midtrans_payment = (object) $midtrans_payment;

        return view('basicpayment::index', compact('payment_setting','basic_payment', 'currencies', 'midtrans_payment'));
    }

    public function update_stripe(Request $request)
    {
        checkAdminHasPermissionAndThrowException('basic.payment.update');
        $rules = [
            'stripe_key'         => 'required',
            'stripe_secret'      => 'required',
            'stripe_charge'      => 'required|numeric',
        ];
        $customMessages = [
            'stripe_key.required'         => __('Stripe key is required'),
            'stripe_secret.required'      => __('Stripe secret is required'),
            'stripe_charge.required'      => __('Gateway charge is required'),
            'stripe_charge.numeric'       => __('Gateway charge should be numeric'),
        ];

        $request->validate($rules, $customMessages);

        BasicPayment::where('key', 'stripe_key')->update(['value' => $request->stripe_key]);
        BasicPayment::where('key', 'stripe_secret')->update(['value' => $request->stripe_secret]);
        BasicPayment::where('key', 'stripe_charge')->update(['value' => $request->stripe_charge]);
        BasicPayment::where('key', 'stripe_status')->update(['value' => $request->stripe_status]);

        if ($request->file('stripe_image')) {
            $stripe_setting = BasicPayment::where('key', 'stripe_image')->first();
            $file_name = file_upload($request->stripe_image, 'uploads/custom-images/', $stripe_setting->value);
            $stripe_setting->value = $file_name;
            $stripe_setting->save();
        }
        $this->put_basic_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_paypal(Request $request)
    {
        checkAdminHasPermissionAndThrowException('basic.payment.update');

        $rules = [
            'paypal_client_id'   => 'required',
            'paypal_secret_key'  => 'required',
            'paypal_charge'      => 'required|numeric',
            'paypal_app_id'      => 'required',
        ];

        $customMessages = [
            'paypal_client_id.required'   => __('Client is required'),
            'paypal_secret_key.required'  => __('Secret key is required'),
            'paypal_charge.required'      => __('Gateway charge is required'),
            'paypal_charge.numeric'       => __('Gateway charge should be numeric'),
            'paypal_app_id.required'       => __('Paypal app id is required'),
        ];

        $request->validate($rules, $customMessages);

        BasicPayment::where('key', 'paypal_client_id')->update(['value' => $request->paypal_client_id]);
        BasicPayment::where('key', 'paypal_secret_key')->update(['value' => $request->paypal_secret_key]);
        BasicPayment::where('key', 'paypal_charge')->update(['value' => $request->paypal_charge]);
        BasicPayment::where('key', 'paypal_status')->update(['value' => $request->paypal_status]);
        BasicPayment::where('key', 'paypal_account_mode')->update(['value' => $request->paypal_account_mode]);
        BasicPayment::where('key', 'paypal_app_id')->update(['value' => $request->paypal_app_id]);

        if ($request->file('paypal_image')) {
            $paypal_setting = BasicPayment::where('key', 'paypal_image')->first();
            $file_name = file_upload($request->paypal_image, 'uploads/custom-images/', $paypal_setting->value);
            $paypal_setting->value = $file_name;
            $paypal_setting->save();
        }
        $this->put_basic_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function update_bank_payment(Request $request)
    {
        checkAdminHasPermissionAndThrowException('basic.payment.update');

        $rules = [
            'bank_information' => 'required',
        ];

        $customMessages = [
            'bank_information.required' => __('Bank information is required'),
            'bank_charge.required'      => __('Gateway charge is required'),
            'bank_charge.numeric'       => __('Gateway charge should be numeric'),
        ];

        $request->validate($rules, $customMessages);

        BasicPayment::where('key', 'bank_information')->update(['value' => $request->bank_information]);
        BasicPayment::where('key', 'bank_charge')->update(['value' => 0]);
        BasicPayment::where('key', 'bank_status')->update(['value' => $request->bank_status]);

        if ($request->file('bank_image')) {
            $bank_setting = BasicPayment::where('key', 'bank_image')->first();
            $file_name = file_upload($request->bank_image, 'uploads/custom-images/', $bank_setting->value);
            $bank_setting->value = $file_name;
            $bank_setting->save();
        }

        $this->put_basic_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    private function put_basic_payment_cache()
    {
        $payment_info = BasicPayment::get();
        $basic_payment = [];
        foreach ($payment_info as $payment_item) {
            $basic_payment[$payment_item->key] = $payment_item->value;
        }
        $basic_payment = (object) $basic_payment;
        Cache::put('basic_payment', $basic_payment);
    }

    public function update_midtrans(Request $request)
    {
        checkAdminHasPermissionAndThrowException('basic.payment.update');
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
}
