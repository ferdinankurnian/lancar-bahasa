<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CustomRecaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Order\app\Models\Enrollment;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $setting = Cache::get('setting');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => $setting->recaptcha_status == 'active' ? ['required', new CustomRecaptcha()] : 'nullable',
        ];

        $customMessages = [
            'email.required' => __('Email is required'),
            'password.required' => __('Password is required'),
            'g-recaptcha-response.required' => __('Please complete the recaptcha to submit the form'),
        ];
        $this->validate($request, $rules, $customMessages);

        $credential = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = User::where('email', $request->email)->first();

        // Check if user exists and password match
        if (!$user || !Hash::check($request->password, $user->password)) {
            $notification = __('Invalid credentials please check your email and password');
            throw ValidationException::withMessages(['email' => $notification]);
        }

        // Check if user active
        if ($user->status != UserStatus::ACTIVE->value) {
            $notification = __('Inactive account');
            throw ValidationException::withMessages(['email' => $notification]);
        }

        // Check if user is banned
        if ($user->is_banned == UserStatus::BANNED->value) {
            $notification = __('Your account has been banned');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

        // Check if email is verified
        if (!$user->email_verified_at) {
            $notification = __('Please verify your email');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

        // Authenticate user
        Auth::guard('web')->attempt($credential, $request->remember);

        // Redirect user to dashboard based on role
        $notification = __('Logged in successfully.');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        $intendedUrl = session()->get('url.intended');
        if ($intendedUrl && \Str::contains($intendedUrl, '/admin')) {
            if($user->role == 'instructor')  return redirect()->route('instructor.dashboard') ;
            return redirect()->route('student.dashboard');
        }

        return redirect()->intended(
            $user->role === 'instructor' ?
                route('instructor.dashboard') : route('student.dashboard')
        )->with($notification);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $notification = __('Logged out successfully.');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('login')->with($notification);
    }
}
