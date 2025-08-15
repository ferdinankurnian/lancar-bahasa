<?php

namespace Modules\GlobalSetting\app\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\MailSenderTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\GlobalSetting\app\Models\Setting;
use Modules\GlobalSetting\app\Models\EmailTemplate;

class EmailSettingController extends Controller
{
    use MailSenderTrait;
    public function email_config()
    {
        checkAdminHasPermissionAndThrowException('setting.view');
        $templates = EmailTemplate::all();

        return view('globalsetting::email.email_config', compact('templates'));
    }

    public function update_email_config(Request $request)
    {
        checkAdminHasPermissionAndThrowException('setting.update');
        $request->validate([
            'mail_sender_name' => 'required',
            'contact_message_receiver_mail' => 'required',
            'mail_host' => 'required',
            'mail_sender_email' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_port' => 'required',
            'mail_encryption' => 'required',
        ], [
            'mail_sender_name.required' => __('Sender name is required'),
            'mail_host.required' => __('Mail host is required'),
            'mail_sender_email.required' => __('Email is required'),
            'mail_username.required' => __('Smtp username is required'),
            'mail_password.unique' => __('Smtp password is required'),
            'mail_port.required' => __('Mail port is required'),
            'mail_encryption.required' => __('Mail encryption is required'),
            'contact_message_receiver_mail.required' => __('Recipient is required'),
        ]);

        Setting::where('key', 'mail_sender_name')->update(['value' => $request->mail_sender_name]);
        Setting::where('key', 'mail_host')->update(['value' => $request->mail_host]);
        Setting::where('key', 'mail_sender_email')->update(['value' => $request->mail_sender_email]);
        Setting::where('key', 'contact_message_receiver_mail')->update(['value' => $request->contact_message_receiver_mail]);
        Setting::where('key', 'mail_username')->update(['value' => $request->mail_username]);
        Setting::where('key', 'mail_password')->update(['value' => $request->mail_password]);
        Setting::where('key', 'mail_port')->update(['value' => $request->mail_port]);
        Setting::where('key', 'mail_encryption')->update(['value' => $request->mail_encryption]);

        $setting_config = new GlobalSettingController();
        $setting_config->put_setting_cache();

        $notification = __('Update Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function edit_email_template($id)
    {
        checkAdminHasPermissionAndThrowException('setting.view');
        $template = EmailTemplate::where('id', $id)->first();
        if ($template->name == 'password_reset') {
            return view('globalsetting::email.template.password_reset', compact('template'));
        } elseif ($template->name == 'contact_mail') {
            return view('globalsetting::email.template.contact_mail', compact('template'));
        } elseif ($template->name == 'subscribe_notification') {
            return view('globalsetting::email.template.subscribe_notification', compact('template'));
        } elseif ($template->name == 'user_verification') {
            return view('globalsetting::email.template.user_verification', compact('template'));
        } elseif ($template->name == 'approved_refund') {
            return view('globalsetting::email.template.refund_approval', compact('template'));
        } elseif ($template->name == 'new_refund') {
            return view('globalsetting::email.template.new_refund', compact('template'));
        } elseif ($template->name == 'pending_wallet_payment') {
            return view('globalsetting::email.template.pending_wallet_payment', compact('template'));
        } elseif ($template->name == 'approved_withdraw') {
            return view('globalsetting::email.template.approved_withdraw', compact('template'));
        } elseif ($template->name == 'instructor_request_approved') {
            return view('globalsetting::email.template.instructor_request_approved', compact('template'));
        } elseif ($template->name == 'instructor_request_pending') {
            return view('globalsetting::email.template.instructor_request_pending', compact('template'));
        } elseif ($template->name == 'instructor_request_rejected') {
            return view('globalsetting::email.template.instructor_request_rejected', compact('template'));
        } elseif ($template->name == 'instructor_quick_contact') {
            return view('globalsetting::email.template.instructor_quick_contact', compact('template'));
        } elseif ($template->name == 'order_completed') {
            return view('globalsetting::email.template.order_completed', compact('template'));
        } elseif ($template->name == 'qna_reply_mail') {
            return view('globalsetting::email.template.qna_reply_mail', compact('template'));
        }elseif ($template->name == 'live_class_mail') {
            return view('globalsetting::email.template.live_class_mail', compact('template'));
        } else {
            $notification = __('Something went wrong');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

    }

    public function update_email_template(Request $request, $id)
    {
        checkAdminHasPermissionAndThrowException('setting.update');
        $rules = [
            'subject' => 'required',
            'message' => 'required',
        ];
        $customMessages = [
            'subject.required' => __('Subject is required'),
            'message.required' => __('Message is required'),
        ];

        $request->validate($rules, $customMessages);

        $template = EmailTemplate::find($id);
        if ($template) {
            $template->subject = $request->subject;
            $template->message = $request->message;
            $template->save();
            $notification = __('Updated Successfully');
            $notification = ['messege' => $notification, 'alert-type' => 'success'];

            return redirect()->route('admin.email-configuration')->with($notification);
        } else {
            $notification = __('Something went wrong');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }
    }

    public function test_mail_credentials()
    {
        abort_unless(checkAdminHasPermission('setting.view'), 403);
        try{
            set_time_limit(0.3);
            self::setMailConfig();
            $result = Mail::raw('This is a test email', function ($message) {
                $message->to('example@gmail.com')->subject('Test Email');
            });
            if($result){
                $notification = __('Mail Send Successfully');
                $notification = ['messege' => $notification, 'alert-type' => 'success'];
                return redirect()->back()->with($notification);
            }
            $notification = __("Mail Can't be sent.");
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }catch(Exception $e){
            $notification = __('Invalid Mail Credentials');
            $notification = ['messege' => $notification, 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

    }
}
