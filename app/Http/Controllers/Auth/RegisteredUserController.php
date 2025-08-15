<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CustomRecaptcha;
use App\Services\MailSenderService;
use App\Traits\GetGlobalInformationTrait;
use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Str;

class RegisteredUserController extends Controller
{
    use GetGlobalInformationTrait;

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $setting = Cache::get('setting');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:4', 'max:100'],
            'g-recaptcha-response' => $setting->recaptcha_status == 'active' ? ['required', new CustomRecaptcha()] : '',
        ], [
            'name.required' => __('Name is required'),
            'email.required' => __('Email is required'),
            'email.unique' => __('Email already exist'),
            'password.required' => __('Password is required'),
            'password.confirmed' => __('Confirm password does not match'),
            'password.min' => __('You have to provide minimum 4 character password'),
            'g-recaptcha-response.required' => __('Please complete the recaptcha to submit the form'),
        ]);

        $user = User::create([
            'role' => 'student',
            'name' => $request->name,
            'email' => $request->email,
            'status' => 'active',
            'is_banned' => 'no',
            'password' => Hash::make($request->password),
            'verification_token' => Str::random(100),
        ]);

        $settings = cache()->get('setting');
        $marketingSettings = cache()->get('marketing_setting');
        if ($user && $settings->google_tagmanager_status == 'active' && $marketingSettings->register) {
            $register_user = [
                'name' => $user->name,
                'email' => $user->email,
            ];
            session()->put('registerUser', $register_user);
        }

        (new MailSenderService)->sendVerifyMailToUserFromTrait('single_user', $user);

        $notification = __('A varification link has been send to your mail, please verify and enjoy our service');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function custom_user_verification($token)
    {

        $user = User::where('verification_token', $token)->first();
        if ($user) {

            if ($user->email_verified_at != null) {
                $notification = __('Email already verified');
                $notification = ['messege' => $notification, 'alert-type' => 'error'];

                return redirect()->route('login')->with($notification);
            }

            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_token = null;
            $user->save();

            $notification = __('Verification successful please try to login now');
            $notification = ['messege' => $notification, 'alert-type' => 'success'];
            return redirect()->route('login')->with($notification);
        } else {
            $notification = __('Invalid token');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->route('register')->with($notification);
        }
    }
}
