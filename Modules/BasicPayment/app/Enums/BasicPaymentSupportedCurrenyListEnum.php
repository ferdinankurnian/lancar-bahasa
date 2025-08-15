<?php

namespace Modules\BasicPayment\app\Enums;

use Illuminate\Support\Str;

enum BasicPaymentSupportedCurrenyListEnum
{
    public static function getStripeSupportedCurrencies(): array
    {
        $allCurrencyCodes = [
            'USD', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN',
            'BAM', 'BBD', 'BDT', 'BGN', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD',
            'BWP', 'BYN', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC',
            'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'EUR', 'FJD',
            'FKP', 'GBP', 'GEL', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL',
            'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JMD', 'JPY', 'KES', 'KGS',
            'KHR', 'KMF', 'KRW', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL',
            'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MUR', 'MVR', 'MWK',
            'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB',
            'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB',
            'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 'SHP', 'SLE', 'SOS', 'SRD',
            'STD', 'SZL', 'THB', 'TJS', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH',
            'UGX', 'UYU', 'UZS', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF',
            'YER', 'ZAR', 'ZMW', 'BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW',
            'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF', 'BHD',
            'JOD', 'KWD', 'OMR', 'TND',
        ];

        $nonZeroCurrencyCodes = ['BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF'];

        $threeDigitCurrencyCodes = ['BHD', 'JOD', 'KWD', 'OMR', 'TND'];

        $smallestUnitCurrencyCodes = array_diff($allCurrencyCodes, $nonZeroCurrencyCodes, $threeDigitCurrencyCodes);

        return [
            'all_currency_codes' => $allCurrencyCodes,
            'smallest_unit_currency_codes' => $smallestUnitCurrencyCodes,
            'non_zero_currency_codes' => $nonZeroCurrencyCodes,
            'three_digit_currency_codes' => $threeDigitCurrencyCodes,
        ];
    }

    public static function isStripeSupportedCurrencies($code): bool
    {
        return in_array(Str::upper($code), self::getStripeSupportedCurrencies()['all_currency_codes']);
    }

    public static function getPaypalSupportedCurrencies(): array
    {
        return ['AUD', 'BRL', 'CAD', 'CNY', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK', 'PHP', 'PLN', 'GBP', 'SGD', 'SEK', 'CHF', 'THB', 'USD'];
    }

    public static function isPaypalSupportedCurrencies($code): bool
    {
        return in_array(Str::upper($code), self::getPaypalSupportedCurrencies());
    }
}
