<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function custom_reset_password_page(Request $request, $token)
    {

        $admin = Admin::select('id', 'name', 'email', 'forget_password_token')->where('forget_password_token', $token)->first();

        if (! $admin) {
            $notification = __('Invalid token, please try again');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->route('password.request')->with($notification);
        }

        return view('admin.auth.reset-password', ['admin' => $admin, 'token' => $token]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function custom_reset_password_store(Request $request, $token)
    {

        $setting = Cache::get('setting');

        $rules = [
            'email' => 'required',
            'password' => 'required|min:4|confirmed',
        ];
        $customMessages = [
            'email.required' => __('Email is required'),
            'password.required' => __('Password is required'),
            'password.min' => __('Password must be 4 characters'),
        ];
        $this->validate($request, $rules, $customMessages);

        $admin = Admin::select('id', 'name', 'email', 'forget_password_token')->where('forget_password_token', $token)->where('email', $request->email)->first();

        if (! $admin) {
            $notification = __('Invalid token, please try again');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

        $admin->password = Hash::make($request->password);
        $admin->forget_password_token = null;
        $admin->save();

        $notification = __('Password Reset successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.login')->with($notification);

    }
}
