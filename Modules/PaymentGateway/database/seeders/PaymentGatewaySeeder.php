<?php

namespace Modules\PaymentGateway\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Currency\app\Models\MultiCurrency;
use Modules\PaymentGateway\app\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_info = [
            'razorpay_key' => 'razorpay_key',
            'razorpay_secret' => 'razorpay_secret',
            'razorpay_name' => 'WebSolutionUs',
            'razorpay_description' => 'This is test payment window',
            'razorpay_charge' => 0.00,
            'razorpay_theme_color' => '#6d0ce4',
            'razorpay_status' => 'inactive',
            'razorpay_currency_id' => MultiCurrency::where('currency_code', 'INR')->first()?->id,
            'razorpay_image' => 'uploads/website-images/razorpay.jpeg',
            'flutterwave_public_key' => 'flutterwave_public_key',
            'flutterwave_secret_key' => 'flutterwave_secret_key',
            'flutterwave_app_name' => 'WebSolutionUs',
            'flutterwave_charge' => 0.00,
            'flutterwave_currency_id' => MultiCurrency::where('currency_code', 'NGN')->first()?->id,
            'flutterwave_status' => 'inactive',
            'flutterwave_image' => 'uploads/website-images/flutterwave.jpg',
            'paystack_public_key' => 'paystack_public_key',
            'paystack_secret_key' => 'paystack_secret_key',
            'paystack_status' => 'inactive',
            'paystack_charge' => 0.00,
            'paystack_image' => 'uploads/website-images/paystack.png',
            'paystack_currency_id' => MultiCurrency::where('currency_code', 'NGN')->first()?->id,
            'mollie_key' => 'mollie_key',
            'mollie_charge' => 0.00,
            'mollie_image' => 'uploads/website-images/mollie.png',
            'mollie_status' => 'inactive',
            'mollie_currency_id' => MultiCurrency::where('currency_code', 'CAD')->first()?->id,
            'instamojo_account_mode' => 'Sandbox',
            'instamojo_api_key' => 'instamojo_api_key',
            'instamojo_auth_token' => 'instamojo_auth_token',
            'instamojo_charge' => 0.00,
            'instamojo_image' => 'uploads/website-images/instamojo.png',
            'instamojo_currency_id' => MultiCurrency::where('currency_code', 'INR')->first()?->id,
            'instamojo_status' => 'inactive',
        ];

        foreach ($payment_info as $index => $payment_item) {
            $new_item = new PaymentGateway();
            $new_item->key = $index;
            $new_item->value = $payment_item;
            $new_item->save();
        }
    }
}
