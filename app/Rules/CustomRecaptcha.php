<?php

namespace App\Rules;

use Cache;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ReCaptcha\ReCaptcha;

class CustomRecaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $setting = Cache::get('setting');

        $recaptcha = new ReCaptcha($setting->recaptcha_secret_key);
        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);
        if (! $response->isSuccess()) {
            $notify_message = __('Please complete the recaptcha to submit the form');
            $fail($notify_message);
        }
    }
}
