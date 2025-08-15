<?php

namespace Modules\PaymentGateway\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\PaymentGateway\app\Models\PaymentGateway;

class PaymentGatewayController extends Controller
{
    public function razorpay_update(Request $request)
    {
        checkAdminHasPermissionAndThrowException('payment.update');
        $rules = [
            'razorpay_key' => 'required',
            'razorpay_secret' => 'required',
            'razorpay_charge' => 'required|numeric',
            'razorpay_name' => 'required',
            'razorpay_description' => 'required',
            'razorpay_theme_color' => 'required',
        ];
        $customMessages = [
            'razorpay_key.required' => __('Razorpay key is required'),
            'razorpay_secret.required' => __('Razorpay secret is required'),
            'razorpay_charge.required' => __('Gateway charge is required'),
            'razorpay_charge.numeric' => __('Gateway charge should be numeric'),
            'razorpay_name.required' => __('Name is required'),
            'razorpay_description.required' => __('Description is required'),
            'razorpay_theme_color.required' => __('Theme is required'),
        ];

        $request->validate($rules, $customMessages);

        PaymentGateway::where('key', 'razorpay_key')->update(['value' => $request->razorpay_key]);
        PaymentGateway::where('key', 'razorpay_secret')->update(['value' => $request->razorpay_secret]);
        PaymentGateway::where('key', 'razorpay_charge')->update(['value' => $request->razorpay_charge]);
        PaymentGateway::where('key', 'razorpay_status')->update(['value' => $request->razorpay_status]);
        PaymentGateway::where('key', 'razorpay_name')->update(['value' => $request->razorpay_name]);
        PaymentGateway::where('key', 'razorpay_description')->update(['value' => $request->razorpay_description]);
        PaymentGateway::where('key', 'razorpay_theme_color')->update(['value' => $request->razorpay_theme_color]);

        if ($request->file('razorpay_image')) {
            $razorpay_setting = PaymentGateway::where('key', 'razorpay_image')->first();
            $file_name = file_upload($request->razorpay_image, 'uploads/custom-images/', $razorpay_setting->value);
            $razorpay_setting->value = $file_name;
            $razorpay_setting->save();
        }

        $this->put_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function flutterwave_update(Request $request)
    {
        checkAdminHasPermissionAndThrowException('payment.update');
        $rules = [
            'flutterwave_public_key' => 'required',
            'flutterwave_secret_key' => 'required',
            'flutterwave_charge' => 'required|numeric',
            'flutterwave_app_name' => 'required',
        ];
        $customMessages = [
            'flutterwave_public_key.required' => __('Public key is required'),
            'flutterwave_secret_key.required' => __('Secret key is required'),
            'flutterwave_charge.required' => __('Gateway charge is required'),
            'flutterwave_charge.numeric' => __('Gateway charge should be numeric'),
            'flutterwave_app_name.required' => __('Name is required'),
        ];

        $request->validate($rules, $customMessages);

        PaymentGateway::where('key', 'flutterwave_charge')->update(['value' => $request->flutterwave_charge]);
        PaymentGateway::where('key', 'flutterwave_public_key')->update(['value' => $request->flutterwave_public_key]);
        PaymentGateway::where('key', 'flutterwave_secret_key')->update(['value' => $request->flutterwave_secret_key]);
        PaymentGateway::where('key', 'flutterwave_app_name')->update(['value' => $request->flutterwave_app_name]);
        PaymentGateway::where('key', 'flutterwave_status')->update(['value' => $request->flutterwave_status]);

        if ($request->file('flutterwave_image')) {
            $flutterwave_setting = PaymentGateway::where('key', 'flutterwave_image')->first();
            $file_name = file_upload($request->flutterwave_image, 'uploads/custom-images/', $flutterwave_setting->value);
            $flutterwave_setting->value = $file_name;
            $flutterwave_setting->save();
        }

        $this->put_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function paystack_update(Request $request)
    {
        checkAdminHasPermissionAndThrowException('payment.update');
        $rules = [
            'paystack_public_key' => 'required',
            'paystack_secret_key' => 'required',
            'paystack_charge' => 'required|numeric',
        ];
        $customMessages = [
            'paystack_public_key.required' => __('Public key is required'),
            'paystack_secret_key.required' => __('Secret key is required'),
            'paystack_charge.required' => __('Gateway charge is required'),
            'paystack_charge.numeric' => __('Gateway charge should be numeric'),
        ];

        $request->validate($rules, $customMessages);

        PaymentGateway::where('key', 'paystack_charge')->update(['value' => $request->paystack_charge]);
        PaymentGateway::where('key', 'paystack_public_key')->update(['value' => $request->paystack_public_key]);
        PaymentGateway::where('key', 'paystack_secret_key')->update(['value' => $request->paystack_secret_key]);
        PaymentGateway::where('key', 'paystack_status')->update(['value' => $request->paystack_status]);

        if ($request->file('paystack_image')) {
            $paystack_setting = PaymentGateway::where('key', 'paystack_image')->first();
            $file_name = file_upload($request->paystack_image, 'uploads/custom-images/', $paystack_setting->value);
            $paystack_setting->value = $file_name;
            $paystack_setting->save();
        }

        $this->put_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function mollie_update(Request $request)
    {
        checkAdminHasPermissionAndThrowException('payment.update');
        $rules = [
            'mollie_key' => 'required',
            'mollie_charge' => 'required|numeric',
        ];
        $customMessages = [
            'mollie_key.required' => __('Mollie key is required'),
            'mollie_charge.required' => __('Gateway charge is required'),
            'mollie_charge.numeric' => __('Gateway charge should be numeric'),
        ];

        $request->validate($rules, $customMessages);

        PaymentGateway::where('key', 'mollie_charge')->update(['value' => $request->mollie_charge]);
        PaymentGateway::where('key', 'mollie_key')->update(['value' => $request->mollie_key]);
        PaymentGateway::where('key', 'mollie_status')->update(['value' => $request->mollie_status]);

        if ($request->file('mollie_image')) {
            $mollie_setting = PaymentGateway::where('key', 'mollie_image')->first();
            $file_name = file_upload($request->mollie_image, 'uploads/custom-images/', $mollie_setting->value);
            $mollie_setting->value = $file_name;
            $mollie_setting->save();
        }

        $this->put_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function instamojo_update(Request $request)
    {
        checkAdminHasPermissionAndThrowException('payment.update');
        $rules = [
            'instamojo_api_key' => 'required',
            'instamojo_auth_token' => 'required',
            'instamojo_charge' => 'required|numeric',
        ];
        $customMessages = [
            'instamojo_api_key.required' => __('API key is required'),
            'instamojo_auth_token.required' => __('Auth token is required'),
            'instamojo_charge.required' => __('Gateway charge is required'),
            'instamojo_charge.numeric' => __('Gateway charge should be numeric'),
        ];

        $request->validate($rules, $customMessages);

        PaymentGateway::where('key', 'instamojo_charge')->update(['value' => $request->instamojo_charge]);
        PaymentGateway::where('key', 'instamojo_api_key')->update(['value' => $request->instamojo_api_key]);
        PaymentGateway::where('key', 'instamojo_auth_token')->update(['value' => $request->instamojo_auth_token]);
        PaymentGateway::where('key', 'instamojo_status')->update(['value' => $request->instamojo_status]);
        PaymentGateway::where('key', 'instamojo_account_mode')->update(['value' => $request->instamojo_account_mode]);

        if ($request->file('instamojo_image')) {
            $instamojo_setting = PaymentGateway::where('key', 'instamojo_image')->first();
            $file_name = file_upload($request->instamojo_image, 'uploads/custom-images/', $instamojo_setting->value);
            $instamojo_setting->value = $file_name;
            $instamojo_setting->save();
        }

        $this->put_payment_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    private function put_payment_cache() {
        $payment_info = PaymentGateway::get();
        $payment_setting = [];
        foreach ( $payment_info as $payment_item ) {
            $payment_setting[$payment_item->key] = $payment_item->value;
        }

        $payment_setting = (object) $payment_setting;
        Cache::put( 'payment_setting',$payment_setting );
    }
}
