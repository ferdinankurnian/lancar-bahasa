<?php

use App\Models\Course;
use App\Enums\ThemeList;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Modules\Location\app\Models\Country;
use Modules\Order\app\Models\Enrollment;
use App\Traits\GetGlobalInformationTrait;
use Modules\Language\app\Models\Language;
use Modules\GlobalSetting\app\Models\Setting;
use Modules\Currency\app\Models\MultiCurrency;
use Modules\GlobalSetting\app\Models\CustomCode;
use Modules\BasicPayment\app\Models\BasicPayment;
use App\Exceptions\AccessPermissionDeniedException;
use Modules\PaymentGateway\app\Models\PaymentGateway;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

function file_upload(UploadedFile $file, string $path = 'uploads/custom-images/', string | null $oldFile = '', bool $optimize = false) {
    $extention = $file->getClientOriginalExtension();
    $file_name = 'wsus-img' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
    $file_name = $path . $file_name;
    $file->move(public_path($path), $file_name);

    try {
        if ($oldFile && !str($oldFile)->contains('uploads/website-images') && File::exists(public_path($oldFile))) {
            File::delete(public_path($oldFile));
        }

        if ($optimize) {
            ImageOptimizer::optimize(public_path($file_name));
        }
    } catch (Exception $e) {
        Log::info($e->getMessage());
    }

    return $file_name;
}
// file upload method
if (!function_exists('allLanguages')) {
    function allLanguages() {
        $allLanguages = Cache::rememberForever('allLanguages', function () {
            return Language::select('code', 'name', 'direction', 'status')->get();
        });

        if (!$allLanguages) {
            $allLanguages = Language::select('code', 'name', 'direction', 'status')->get();
        }

        return $allLanguages;
    }
}

if (!function_exists('allCurrencies')) {
    function allCurrencies() {
        $allCurrencies = Cache::rememberForever('allCurrencies', function () {
            return MultiCurrency::all();
        });

        if (!$allCurrencies) {
            $allCurrencies = MultiCurrency::all();
        }

        return $allCurrencies;
    }
}

if (!function_exists('getSessionLanguage')) {
    function getSessionLanguage(): string {
        if (!session()->has('lang')) {
            session()->put('lang', config('app.locale'));
            session()->forget('text_direction');
            session()->put('text_direction', 'ltr');
        }

        $lang = Session::get('lang');

        return $lang;
    }
}

if (!function_exists('getSessionCurrency')) {
    function getSessionCurrency(): string {
        if (!session()->has('currency_code') || !session()->has('currency_rate') || !session()->has('currency_position')) {
            $currency = allCurrencies()->where('is_default', 'yes')->first();
            session()->put('currency_code', $currency->currency_code);
            session()->forget('currency_position');
            session()->put('currency_position', $currency->currency_position);
            session()->forget('currency_icon');
            session()->put('currency_icon', $currency->currency_icon);
            session()->forget('currency_rate');
            session()->put('currency_rate', $currency->currency_rate);
        }

        return Session::get('currency_code');
    }
}

function admin_lang() {
    return Session::get('admin_lang');
}
if (!function_exists('getSocialLinks')) {
    function getSocialLinks() {
        return Cache::rememberForever('getSocialLinks', function () {
            return \Modules\SocialLink\app\Models\SocialLink::select('link', 'icon')->get();
        });
    }
}

// calculate currency
function currency($price) {
    getSessionCurrency();
    $currency_icon = Session::get('currency_icon');
    $currency_rate = Session::has('currency_rate') ? Session::get('currency_rate') : 1;
    $currency_position = Session::get('currency_position');

    $price = $price * $currency_rate;
    $price = number_format($price, 0, '.', ',');

    if ($currency_position == 'before_price') {
        $price = $currency_icon . $price;
    } elseif ($currency_position == 'before_price_with_space') {
        $price = $currency_icon . ' ' . $price;
    } elseif ($currency_position == 'after_price') {
        $price = $price . $currency_icon;
    } elseif ($currency_position == 'after_price_with_space') {
        $price = $price . ' ' . $currency_icon;
    } else {
        $price = $currency_icon . $price;
    }

    return $price;
}

// calculate currency

if (!function_exists('userAuth')) {
    function userAuth() {
        return Auth::guard('web')->user();
    }
}
if (!function_exists('adminAuth')) {
    function adminAuth() {
        return Auth::guard('admin')->user();
    }
}

if (!function_exists('getPayableAmount')) {
    function getPayableAmount() {
    }
}
function payable_with_charges($amount): ?array {
    $availablePaymentMethods = [
        'stripe',
        'paypal',
        'razorpay',
        'mollie',
        'instamojo',
        'flutterwave',
        'paystack',
        'bank',
    ];

    getSessionCurrency();

    $currency_rate = Session::has('currency_rate') ? Session::get('currency_rate') : 1;

    $getGlobalInformationClass = new class
        {
        use GetGlobalInformationTrait;
    };

    $payable_with_charges = [];
    foreach ($availablePaymentMethods as $paymentMethod) {
        if ($paymentMethod == 'stripe' || $paymentMethod == 'paypal' || $paymentMethod == 'bank') {
            $basic_payment = $getGlobalInformationClass->get_basic_payment_info();
            $charge_property = $paymentMethod . '_charge';
            $gateway_charge = property_exists($basic_payment, $charge_property) ? $basic_payment->$charge_property : 0;
        } else {
            $payment_setting = $getGlobalInformationClass->get_payment_gateway_info();
            $charge_property = $paymentMethod . '_charge';
            $gateway_charge = property_exists($payment_setting, $charge_property) ? $payment_setting->$charge_property : 0;
        }

        $payable_amount = $amount * $currency_rate;
        $gateway_charge = $payable_amount * ($gateway_charge / 100);
        $payable_with_charge = $payable_amount + $gateway_charge;
        $payable_with_charges[$paymentMethod] = number_format(sprintf('%0.2f', $payable_with_charge));
    }

    return $payable_with_charges;
}

// custom decode and encode input value
function html_decode($text) {
    $after_decode = htmlspecialchars_decode($text, ENT_QUOTES);

    return $after_decode;
}

if (!function_exists('checkAdminHasPermission')) {
    function checkAdminHasPermission($permission): bool {
        return Auth::guard('admin')->user()->can($permission) ? true : false;
    }
}

if (!function_exists('checkAdminHasPermissionAndThrowException')) {
    function checkAdminHasPermissionAndThrowException($permission) {
        if (!checkAdminHasPermission($permission)) {
            throw new AccessPermissionDeniedException();
        }
    }
}

if (!function_exists('getSettingStatus')) {
    function getSettingStatus($key) {
        if (Cache::has('setting')) {
            $setting = Cache::get('setting');
            if (!is_null($key)) {
                return $setting->$key == 'active' ? true : false;
            }
        } else {
            try {
                return Setting::where('key', $key)->first()?->value == 'active' ? true : false;
            } catch (Exception $e) {
                if (app()->isLocal()) {
                    Log::info($e->getMessage());
                }

                return false;
            }
        }

        return false;
    }
}
if (!function_exists('checkCrentials')) {
    function checkCrentials() {
        if (Cache::has('setting') && $settings = Cache::get('setting')) {
            if ($settings->recaptcha_status !== 'inactive' && ($settings->recaptcha_site_key == 'recaptcha_site_key' || $settings->recaptcha_secret_key == 'recaptcha_secret_key' || $settings->recaptcha_site_key == '' || $settings->recaptcha_secret_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Google Recaptcha credentails not found'),
                    'description' => __('This may create a problem while submitting any form submission from website. Please fill up the credential from google account.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->pixel_status !== 'inactive' && ($settings->pixel_app_id == 'pixel_app_id' || $settings->pixel_app_id == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Facebook Pixel credentails not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->facebook_login_status !== 'inactive' && ($settings->facebook_app_id == 'facebook_app_id' || $settings->facebook_app_secret == 'facebook_app_secret' || $settings->facebook_redirect_url == 'facebook_redirect_url' || $settings->facebook_app_id == '' || $settings->facebook_app_secret == '' || $settings->facebook_redirect_url == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Facebook login credentails not found'),
                    'description' => __('This may create a problem while logging in using facebook. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->google_login_status !== 'inactive' && ($settings->gmail_client_id == 'gmail_client_id' || $settings->gmail_secret_id == 'gmail_secret_id' || $settings->gmail_client_id == '' || $settings->gmail_secret_id == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Google login credentails not found'),
                    'description' => __('This may create a problem while logging in using google. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->google_tagmanager_status !== 'inactive' && ($settings->google_tagmanager_id == 'google_tagmanager_id' || $settings->google_tagmanager_id == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Google tag manager credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }
            if ($settings->google_analytic_status !== 'inactive' && ($settings->google_analytic_id == 'google_analytic_id' || $settings->google_analytic_id == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Google analytic credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->tawk_status !== 'inactive' && ($settings->tawk_chat_link == 'tawk_chat_link' || $settings->tawk_chat_link == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Tawk Chat Link credentails not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->pusher_status !== 'inactive' && ($settings->pusher_app_id == 'pusher_app_id' || $settings->pusher_app_key == 'pusher_app_key' || $settings->pusher_app_secret == 'pusher_app_secret' || $settings->pusher_app_cluster == 'pusher_app_cluster' || $settings->pusher_app_id == '' || $settings->pusher_app_key == '' || $settings->pusher_app_secret == '' || $settings->pusher_app_cluster == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Pusher credentails not found'),
                    'description' => __('This may create a problem while logging in using google. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->mail_host == 'mail_host' || $settings->mail_username == 'mail_username' || $settings->mail_password == 'mail_password' || $settings->mail_host == '' || $settings->mail_port == '' || $settings->mail_username == '' || $settings->mail_password == '') {
                return (object) [
                    'status'      => true,
                    'message'     => __('Mail credentails not found'),
                    'description' => __('This may create a problem while sending email. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.email-configuration',
                ];
            }
            if ($settings->wasabi_status !== 'inactive' && ($settings->wasabi_access_id == 'wasabi_access_id' || $settings->wasabi_access_id == '' || $settings->wasabi_secret_key == 'wasabi_secret_key' || $settings->wasabi_secret_key == '' || $settings->wasabi_bucket == 'wasabi_secret_key' || $settings->wasabi_bucket == '' || $settings->wasabi_region == 'wasabi_region' || $settings->wasabi_region == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Wasabi cloud storage credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }
            if ($settings->aws_status !== 'inactive' && ($settings->aws_access_id == 'aws_access_id' || $settings->aws_access_id == '' || $settings->aws_secret_key == 'aws_secret_key' || $settings->aws_secret_key == '' || $settings->aws_bucket == 'aws_secret_key' || $settings->aws_bucket == '' || $settings->aws_region == 'aws_region' || $settings->aws_region == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('AWS cloud storage credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }
        }

        if (!Cache::has('basic_payment') && Module::isEnabled('BasicPayment')) {
            Cache::rememberForever('basic_payment', function () {
                $payment_info = BasicPayment::get();
                $basic_payment = [];
                foreach ($payment_info as $payment_item) {
                    $basic_payment[$payment_item->key] = $payment_item->value;
                }

                return (object) $basic_payment;
            });
        }

        if (Cache::has('basic_payment') && $basicPayment = Cache::get('basic_payment')) {
            if ($basicPayment->stripe_status !== 'inactive' && ($basicPayment->stripe_key == 'stripe_key' || $basicPayment->stripe_secret == 'stripe_secret' || $basicPayment->stripe_key == '' || $basicPayment->stripe_secret == '')) {

                return (object) [
                    'status'      => true,
                    'message'     => __('Stripe credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }

            if ($basicPayment->paypal_status !== 'inactive' && ($basicPayment->paypal_client_id == 'paypal_client_id' || $basicPayment->paypal_secret_key == 'paypal_secret_key' || $basicPayment->paypal_client_id == '' || $basicPayment->paypal_secret_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Paypal credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }
        }

        if (!Cache::has('payment_setting') && Module::isEnabled('PaymentGateway')) {
            Cache::rememberForever('payment_setting', function () {
                $payment_info = PaymentGateway::get();
                $payment_setting = [];
                foreach ($payment_info as $payment_item) {
                    $payment_setting[$payment_item->key] = $payment_item->value;
                }

                return (object) $payment_setting;
            });
        }

        if (Cache::has('payment_setting') && $paymentAddons = Cache::get('payment_setting')) {
            if ($paymentAddons->razorpay_status !== 'inactive' && ($paymentAddons->razorpay_key == 'razorpay_key' || $paymentAddons->razorpay_secret == 'razorpay_secret' || $paymentAddons->razorpay_key == '' || $paymentAddons->razorpay_secret == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Razorpay credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }

            if ($paymentAddons->flutterwave_status !== 'inactive' && ($paymentAddons->flutterwave_public_key == 'flutterwave_public_key' || $paymentAddons->flutterwave_secret_key == 'flutterwave_secret_key' || $paymentAddons->flutterwave_public_key == '' || $paymentAddons->flutterwave_secret_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Flutterwave credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }

            if ($paymentAddons->paystack_status !== 'inactive' && ($paymentAddons->paystack_public_key == 'paystack_public_key' || $paymentAddons->paystack_secret_key == 'paystack_secret_key' || $paymentAddons->paystack_public_key == '' || $paymentAddons->paystack_secret_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Paystack credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }

            if ($paymentAddons->mollie_status !== 'inactive' && ($paymentAddons->mollie_key == 'mollie_key' || $paymentAddons->mollie_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Mollie credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }

            if ($paymentAddons->instamojo_status !== 'inactive' && ($paymentAddons->instamojo_api_key == 'instamojo_api_key' || $paymentAddons->instamojo_auth_token == 'instamojo_auth_token' || $paymentAddons->instamojo_api_key == '' || $paymentAddons->instamojo_auth_token == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Instamojo credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }
        }

        return false;
    }
}

if (!function_exists('isRoute')) {
    function isRoute(string | array $route, string $returnValue = null) {
        if (is_array($route)) {
            foreach ($route as $value) {
                if (Route::is($value)) {
                    return is_null($returnValue) ? true : $returnValue;
                }
            }
            return false;
        }

        if (Route::is($route)) {
            return is_null($returnValue) ? true : $returnValue;
        }

        return false;
    }
}
// get default language
if (!function_exists('getDefaultLanguage')) {
    function getDefaultLanguage(): string {
        // cache default language
        $defaultLanguage = Cache::rememberForever('defaultLanguage', function () {
            try {
                return Language::where('is_default', 1)->first()->code;
            } catch (\Exception $e) {
                info($e->getMessage());
                return 'en';
            }
        });

        return $defaultLanguage;
    }
}

/**
 * Set the tab step for the form
 *
 * @param string $name name of the tab session
 * @param string $step current step of the tab
 *
 * @return void
 */
if (!function_exists('setFormTabStep')) {
    function setFormTabStep(string $name, string $step): void {
        session()->flash($name, $step);
    }
}

/**
 * Get all countries from cache
 *
 * @return Collection all countries
 */
if (!function_exists('countries')) {
    function countries() {
        return Cache::rememberForever("countries", fn() => Country::all());
    }
}

if (!function_exists('instructorStatus')) {
    function instructorStatus() {
        return auth('web')->user()?->instructorInfo?->status;
    }
}
if (!function_exists('customCode')) {
    function customCode() {
        return Cache::rememberForever('customCode', function () {
            return CustomCode::select('css', 'header_javascript', 'javascript')->first();
        });
    }
}

/** Truncate string function */
if (!function_exists('truncate')) {
    function truncate($text, $limit = 60) {
        $text = $text ?? '';
        if (mb_strlen($text) > $limit) {
            return mb_substr($text, 0, $limit) . '...';
        }
        return $text;
    }
}

/** Format date function */
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd M, Y') {
        return Carbon::parse($date)->format($format);
    }
}
if (!function_exists('formatTime')) {
    function formatTime($date, $format = 'h:i a') {
        return Carbon::parse($date)->format($format);
    }
}
if (!function_exists('formattedDateTime')) {
    function formattedDateTime($datetime) {
        return formatDate($datetime) . ' - ' . formatTime($datetime);
    }
}

/** Format minutes to hours */
if (!function_exists('minutesToHours')) {
    function minutesToHours($minutesToHours) {
        if ($minutesToHours === 0 || $minutesToHours === null) {
            return '--.--';
        }

        $hours = floor($minutesToHours / 60);
        $minutes = $minutesToHours % 60;
        return $hours . 'h ' . ($minutes ? $minutes . 'm' : '');
    }
}

/** Set enrollment ids in session */

if (!function_exists('setEnrollmentIdsInSession')) {
    function setEnrollmentIdsInSession() {
        if (auth('web')->check()) {
            $enrollmentsIds = Enrollment::where('user_id', userAuth()->id)->pluck('course_id')->toArray();
            session()->put('enrollments', $enrollmentsIds);
            return;
        }

        session()->put('enrollments', []);
    }
}
/** Set instructor course ids in session */

if (!function_exists('setInstructorCourseIdsInSession')) {
    function setInstructorCourseIdsInSession() {
        if (auth('web')->check() && userAuth()->role == 'instructor') {
            $enrollmentsIds = Course::where('instructor_id', userAuth()->id)->pluck('id')->toArray();
            session()->put('instructor_courses', $enrollmentsIds);
            return;
        }

        session()->put('instructor_courses', []);
    }
}

if (!function_exists('processText')) {
    function processText($text) {
        // Replace text within square brackets with a <span> tag
        $patternSquareBrackets = '/\[(.*?)\]/';
        $replacementSquareBrackets = '<span class="highlight">$1</span>';
        $text = preg_replace($patternSquareBrackets, $replacementSquareBrackets, $text);

        // Replace text within curly brackets with a <span> tag
        $patternCurlyBrackets = '/\{(.*?)\}/';
        $replacementCurlyBrackets = '<b>$1</b>';
        $text = preg_replace($patternCurlyBrackets, $replacementCurlyBrackets, $text);

        // Replace backslashes with <br> tags
        $patternBackslash = '/\\\\/';
        $replacementBackslash = '<br>';
        $text = preg_replace($patternBackslash, $replacementBackslash, $text);

        // Return the modified text
        return $text;
    }
}
function calculateReadingTime($content) {
    // Average reading speed (words per minute)
    $readingSpeed = 200;

    // Strip HTML tags and count the words
    $wordCount = str_word_count(strip_tags($content));

    // Calculate the reading time in minutes
    $readingTime = ceil($wordCount / $readingSpeed);

    return $readingTime;
}

if (!function_exists('getTags')) {
    function getTags($jsonTag = []) {
        $tags = $jsonTag;
        $tags_string = '';
        foreach ($tags as $tag) {
            $tags_string .= $tag->value . ',';
        }
        return $tags_string = rtrim($tags_string, ',');
    }
}
if (!function_exists('extractGoogleDriveVideoId')) {
    function extractGoogleDriveVideoId($url) {
        $googleDriveRegex = '/(?:https?:\/\/)?(?:www\.)?(?:drive\.google\.com\/(?:uc\?id=|file\/d\/|open\?id=)|youtu\.be\/)([\w-]{25,})[?=&#]*/';
        if (preg_match($googleDriveRegex, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}

if (!function_exists('extractAndFilterImageSrc')) {
    function extractAndFilterImageSrc($string) {
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $string, $matches);
        foreach (array_filter(array_map(function ($src) {
            $path = preg_replace('/^.*\/(uploads\/.*)$/', '$1', $src);
            return preg_match('/^uploads\/forum-images\/[^\/]+\.[a-zA-Z]{3,4}$/', $path) ? $path : null;
        }, $matches[1])) as $image) {
            $fullPath = public_path($image);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }

        }
    }
}
if (!function_exists('replaceImageSources')) {
    function replaceImageSources($html) {
        $baseUrl = url('uploads/forum-images/');
        $pattern = '/<img\s+[^>]*src=["\']([^"\']+)["\'][^>]*>/i';

        $replacement = function ($matches) use ($baseUrl) {
            $existingSrc = $matches[1];
            $newSrc = $baseUrl . '/' . basename($existingSrc);
            return str_replace($existingSrc, $newSrc, $matches[0]);
        };
        $newHtml = preg_replace_callback($pattern, $replacement, $html);
        return $newHtml;
    }
}
if (!function_exists('routeList')) {
    function routeList(): object {
        $route_list = [
            (object) ['name' => __('Dashboard'), 'route' => route('admin.dashboard'), 'permission' => 'dashboard.view'],
            (object) ['name' => __('Courses'), 'route' => route('admin.courses.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course Categories'), 'route' => route('admin.course-category.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course languages'), 'route' => route('admin.course-language.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course levels'), 'route' => route('admin.course-level.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course Reviews'), 'route' => route('admin.course-review.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course Delete Requests'), 'route' => route('admin.course-delete-request.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Certificate Builder'), 'route' => route('admin.certificate-builder.index'), 'permission' => 'course.certificate.management'],
            (object) ['name' => __('Badges'), 'route' => route('admin.badges.index'), 'permission' => 'badge.management'],
            (object) ['name' => __('Blog Categories'), 'route' => route('admin.blog-category.index'), 'permission' => 'blog.category.view'],
            (object) ['name' => __('Blog List'), 'route' => route('admin.blogs.index'), 'permission' => 'blog.view'],
            (object) ['name' => __('Blog Comments'), 'route' => route('admin.blog-comment.index'), 'permission' => 'blog.comment.view'],
            (object) ['name' => __('Order History'), 'route' => route('admin.orders'), 'permission' => 'order.management'],
            (object) ['name' => __('Pending Payment'), 'route' => route('admin.pending-orders'), 'permission' => 'order.management'],
            (object) ['name' => __('Coupon List'), 'route' => route('admin.coupon.index'), 'permission' => 'coupon.management'],
            (object) ['name' => __('Withdraw Method'), 'route' => route('admin.withdraw-method.index'), 'permission' => 'withdraw.management'],
            (object) ['name' => __('Withdraw list'), 'route' => route('admin.withdraw-list'), 'permission' => 'withdraw.management'],
            (object) ['name' => __('Instructor Request List'), 'route' => route('admin.instructor-request.index'), 'permission' => 'instructor.request.list'],
            (object) ['name' => __('Instructor Request Settings'), 'route' => route('admin.instructor-request-setting.index'), 'permission' => 'instructor.request.list'],
            (object) ['name' => __('All Students'), 'route' => route('admin.all-customers'), 'permission' => 'customer.view'],
            (object) ['name' => __('All Instructors'), 'route' => route('admin.all-instructors'), 'permission' => 'customer.view'],
            (object) ['name' => __('Active Users'), 'route' => route('admin.active-customers'), 'permission' => 'customer.view'],
            (object) ['name' => __('Non verified Users'), 'route' => route('admin.non-verified-customers'), 'permission' => 'customer.view'],
            (object) ['name' => __('Banned Users'), 'route' => route('admin.banned-customers'), 'permission' => 'customer.view'],
            (object) ['name' => __('Send bulk mail Users'), 'route' => route('admin.send-bulk-mail'), 'permission' => 'customer.view'],
            (object) ['name' => __('Countries'), 'route' => route('admin.country.index'), 'permission' => 'location.view'],
            (object) ['name' => __('Site Themes'), 'route' => route('admin.site-appearance.index'), 'permission' => 'appearance.management'],
            (object) ['name' => __('Section Setting'), 'route' => route('admin.section-setting.index'), 'permission' => 'appearance.management'],
            (object) ['name' => __('Site Colors'), 'route' => route('admin.site-color-setting.index'), 'permission' => 'appearance.management'],
            (object) ['name' => __('About Section'), 'route' => route('admin.about-section.index', ['code' => 'en']), 'permission' => 'section.management'],
            (object) ['name' => __('Featured Course Section'), 'route' => route('admin.featured-course-section.index'), 'permission' => 'section.management'],
            (object) ['name' => __('Newsletter Section'), 'route' => route('admin.newsletter-section.index'), 'permission' => 'section.management'],
            (object) ['name' => __('Featured Instructor'), 'route' => route('admin.featured-instructor-section.edit', ['featured_instructor_section' => 1, 'code' => 'en']), 'permission' => 'section.management'],
            (object) ['name' => __('Counter Section'), 'route' => route('admin.counter-section.index'), 'permission' => 'section.management'],
            (object) ['name' => __('Faq Section'), 'route' => route('admin.faq-section.index', ['code' => 'en']), 'permission' => 'section.management'],
            (object) ['name' => __('Our Features Section'), 'route' => route('admin.our-features-section.index', ['code' => 'en']), 'permission' => 'section.management'],
            (object) ['name' => __('Banner Section'), 'route' => route('admin.banner-section.index'), 'permission' => 'section.management'],
            (object) ['name' => __('Contact Page Section'), 'route' => route('admin.contact-section.index'), 'permission' => 'section.management'],
            (object) ['name' => __('Brands'), 'route' => route('admin.brand.index'), 'permission' => 'brand.managemen'],
            (object) ['name' => __('Footer Setting'), 'route' => route('admin.footersetting.index'), 'permission' => 'footer.management'],
            (object) ['name' => __('Menu Builder'), 'route' => route('admin.menubuilder.index'), 'permission' => 'menu.view'],
            (object) ['name' => __('Page Builder'), 'route' => route('admin.page-builder.index'), 'permission' => 'page.management'],
            (object) ['name' => __('Social Links'), 'route' => route('admin.social-link.index'), 'permission' => 'social.link.management'],
            (object) ['name' => __('FAQS'), 'route' => route('admin.faq.index'), 'permission' => 'faq.view'],
            (object) ['name' => __('Subscriber List'), 'route' => route('admin.subscriber-list'), 'permission' => 'newsletter.view'],
            (object) ['name' => __('Subscriber Send bulk mail'), 'route' => route('admin.send-mail-to-newsletter'), 'permission' => 'newsletter.view'],
            (object) ['name' => __('Testimonial'), 'route' => route('admin.testimonial.index'), 'permission' => 'testimonial.view'],
            (object) ['name' => __('Contact Messages'), 'route' => route('admin.contact-messages'), 'permission' => 'contect.message.view'],
            (object) ['name' => __('General Settings'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'general_tab'],
            (object) ['name' => __('Logo & Favicon'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'logo_favicon_tab'],
            (object) ['name' => __('Cookie Consent'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'cookie_consent_tab'],
            (object) ['name' => __('Breadcrumb image'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'breadcrump_img_tab'],
            (object) ['name' => __('Copyright Text'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'copyright_text_tab'],
            (object) ['name' => __('Maintenance Mode'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'mmaintenance_mode_tab'],
            (object) ['name' => __('Credential Settings'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'google_recaptcha_tab'],
            (object) ['name' => __('Google reCaptcha'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'google_recaptcha_tab'],
            (object) ['name' => __('Google Tag Manager'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'google_tag_tab'],
            (object) ['name' => __('Wasabi Cloud Storage'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'wasabi_tab'],
            (object) ['name' => __('AWS Cloud Storage'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'aws_tab'],
            (object) ['name' => __('Google Analytic'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'google_analytic_tab'],
            (object) ['name' => __('Facebook Pixel'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'facebook_pixel_tab'],
            (object) ['name' => __('Social Login'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'social_login_tab'],
            (object) ['name' => __('Tawk Chat'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'tawk_chat_tab'],
            (object) ['name' => __('Email Configuration'), 'route' => route('admin.email-configuration'), 'permission' => 'setting.view', 'tab' => 'setting_tab'],
            (object) ['name' => __('Email Template'), 'route' => route('admin.email-configuration'), 'permission' => 'setting.view', 'tab' => 'email_template_tab'],
            (object) ['name' => __('SEO Setup'), 'route' => route('admin.seo-setting'), 'permission' => 'setting.view'],
            (object) [
                'name'       => __('Custom CSS'),
                'route'      => route('admin.custom-code', ['type' => 'css']),
                'permission' => 'setting.view',
            ],
            (object) [
                'name'       => __('Custom JS'),
                'route'      => route('admin.custom-code', ['type' => 'js']),
                'permission' => 'setting.view',
            ],
            (object) [
                'name'       => __('Marketing Settings'),
                'route'      => route('admin.marketing-setting'),
                'permission' => 'setting.view',
            ],
            (object) ['name' => __('Clear cache'), 'route' => route('admin.cache-clear'), 'permission' => 'setting.view'],
            (object) ['name' => __('Database Clear'), 'route' => route('admin.database-clear'), 'permission' => 'setting.view'],
            (object) ['name' => __('System Update'), 'route' => route('admin.system-update.index'), 'permission' => 'setting.view'],
            (object) ['name' => __('Admin Commission'), 'route' => route('admin.commission-setting'), 'permission' => 'setting.view'],
            (object) ['name' => __('Manage Language'), 'route' => route('admin.languages.index'), 'permission' => 'language.view'],
            (object) ['name' => __('Basic Payment'), 'route' => route('admin.basicpayment'), 'permission' => 'basic.payment.view'],
            (object) ['name' => __('Multi Currency'), 'route' => route('admin.currency.index'), 'permission' => 'currency.view'],
            (object) ['name' => __('Manage Admin'), 'route' => route('admin.admin.index'), 'permission' => 'admin.view'],
            (object) ['name' => __('Role & Permissions'), 'route' => route('admin.role.index'), 'permission' => 'role.view'],
        ];

        if(config('app.default_homepage') == ThemeList::BUSINESS->value){
            $route_list[] = (object) ['name' => __('Slider Section'), 'route' => route('admin.slider-section.index', ['code' => 'en']), 'permission' => 'section.management'];
        }else{
            $route_list[] = (object) ['name' => __('Hero Section'), 'route' => route('admin.hero-section.index', ['code' => 'en']), 'permission' => 'section.management'];
        }
        if(in_array(config('app.default_homepage'),[ThemeList::MAIN->value, ThemeList::ONLINE->value, ThemeList::UNIVERSITY->value,ThemeList::LANGUAGE->value])){
            $route_list[] = (object) ['name' => __('Counter Section'), 'route' => route('admin.counter-section.index'), 'permission' => 'section.management'];
        }

        usort($route_list, function ($a, $b) {
            return strcmp($a->name, $b->name);
        });

        return (object) $route_list;
    }
}
//wasabi config setup
if (!function_exists('adminSearchRouteList')) {
    function adminSearchRouteList() {
        return Cache::rememberForever('adminSearchRouteList', function () {
            return routeList();
        });
    }
}
//wasabi config setup
if (!function_exists('set_wasabi_config')) {
    function set_wasabi_config() {
        $wasabi_setting = Cache::get('setting');
        config(['filesystems.disks.wasabi.key' => $wasabi_setting?->wasabi_access_id]);
        config(['filesystems.disks.wasabi.secret' => $wasabi_setting?->wasabi_secret_key]);
        config(['filesystems.disks.wasabi.bucket' => $wasabi_setting?->wasabi_bucket]);
        config(['filesystems.disks.wasabi.region' => $wasabi_setting?->wasabi_region]);
    }
}
if (!function_exists('set_aws_config')) {
    function set_aws_config() {
        $aws_setting = Cache::get('setting');
        config(['filesystems.disks.aws.key' => $aws_setting?->aws_access_id]);
        config(['filesystems.disks.aws.secret' => $aws_setting?->aws_secret_key]);
        config(['filesystems.disks.aws.bucket' => $aws_setting?->aws_bucket]);
        config(['filesystems.disks.aws.region' => $aws_setting?->aws_region]);
        config(['filesystems.disks.aws.url' => "https://{$aws_setting?->aws_bucket}.s3.amazonaws.com/"]);
    }
}
if (!function_exists('generateUniqueSlug')) {
    /**
     * Generate a unique slug for a model based on an initial base slug.
     *
     * @param string $model The model class to check for existing slugs (e.g., Course::class).
     * @param string $title The title to convert to a base slug.
     * @return string A unique slug string that can be safely used in the model.
     */
    function generateUniqueSlug($model, $title):string {
        $baseSlug = Str::slug($title, '-');

        $slug = $baseSlug;
        $counter = 1;

        while ($model::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        return $slug;
    }
}