<?php

namespace Modules\ContactMessage\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Rules\CustomRecaptcha;
use Cache;
use Illuminate\Http\Request;
use Modules\ContactMessage\app\Jobs\ContactMessageSendJob;
use Modules\ContactMessage\app\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $setting = Cache::get('setting');

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => $setting->recaptcha_status == 'active' ? ['required', new CustomRecaptcha()] : '',
        ], [
            'name.required' => __('Name is required'),
            'email.required' => __('Email is required'),
            'subject.required' => __('Subject is required'),
            'message.required' => __('Message is required'),
            'g-recaptcha-response.required' => __('Please complete the recaptcha to submit the form'),
        ]);

        $new_message = new ContactMessage();
        $new_message->name = $request->name;
        $new_message->email = $request->email;
        $new_message->subject = $request->subject;
        $new_message->message = $request->message;
        $new_message->phone = $request->phone;
        $new_message->save();

        dispatch(new ContactMessageSendJob($new_message));

        return response()->json(['message' => __('Message send successfull')]);
    }
}
