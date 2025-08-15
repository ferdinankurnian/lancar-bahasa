<?php

namespace Modules\Currency\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Currency\app\Models\MultiCurrency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! MultiCurrency::first()) {
            // stripe, paypal, bank, default currency
            $currency = new MultiCurrency();
            $currency->currency_name = '$-USD';
            $currency->country_code = 'US';
            $currency->currency_code = 'USD';
            $currency->currency_icon = '$';
            $currency->is_default = 'yes';
            $currency->currency_rate = 1;
            $currency->currency_position = 'before_price';
            $currency->status = 'active';
            $currency->save();

            // flutterwaves, paystack currency
            $currency = new MultiCurrency();
            $currency->currency_name = '₦-Naira';
            $currency->country_code = 'NG';
            $currency->currency_code = 'NGN';
            $currency->currency_icon = '₦';
            $currency->is_default = 'no';
            $currency->currency_rate = 417.35;
            $currency->currency_position = 'before_price';
            $currency->status = 'active';
            $currency->save();

            // instamojo, razorpay currency
            $currency = new MultiCurrency();
            $currency->currency_name = '₹-Rupee';
            $currency->country_code = 'IN';
            $currency->currency_code = 'INR';
            $currency->currency_icon = '₹';
            $currency->is_default = 'no';
            $currency->currency_rate = 74.66;
            $currency->currency_position = 'before_price';
            $currency->status = 'active';
            $currency->save();

            // paymongo currency
            $currency = new MultiCurrency();
            $currency->currency_name = '₱-Peso';
            $currency->country_code = 'PH';
            $currency->currency_code = 'PHP';
            $currency->currency_icon = '₱';
            $currency->is_default = 'no';
            $currency->currency_rate = 55.07;
            $currency->currency_position = 'before_price';
            $currency->status = 'active';
            $currency->save();

            // mollie currency
            $currency = new MultiCurrency();
            $currency->currency_name = '$-CAD';
            $currency->country_code = 'CA';
            $currency->currency_code = 'CAD';
            $currency->currency_icon = '$';
            $currency->is_default = 'no';
            $currency->currency_rate = 1.27;
            $currency->currency_position = 'before_price';
            $currency->status = 'active';
            $currency->save();

            // Bangladeshi Currency
            $currency = new MultiCurrency();
            $currency->currency_name = '৳-Taka';
            $currency->country_code = 'BD';
            $currency->currency_code = 'BDT';
            $currency->currency_icon = '৳';
            $currency->is_default = 'no';
            $currency->currency_rate = 80;
            $currency->currency_position = 'before_price';
            $currency->status = 'active';
            $currency->save();
        }
    }
}
