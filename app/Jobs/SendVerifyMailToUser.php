<?php

namespace App\Jobs;

use Exception;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\UserRegistration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Traits\GetGlobalInformationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\GlobalSetting\app\Models\EmailTemplate;

class SendVerifyMailToUser implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    private $user_type;

    private $user_info;

    public function __construct($user_type, $user_info = null)
    {
        $this->user_type = $user_type;
        $this->user_info = $user_info;
    }

    public function handle(): void
    {
        $this->set_mail_config();

        if ($this->user_type == 'all_user') {
            $users = User::where('email_verified_at', null)->orderBy('id', 'desc')->get();
            foreach ($users as $index => $user) {
                $user->verification_token = \Illuminate\Support\Str::random(100);
                $user->save();

                try {
                    $template = EmailTemplate::where('name', 'user_verification')->first();
                    $subject = $template->subject;
                    $message = $template->message;
                    $message = str_replace('{{user_name}}', $user->name, $message);

                    Mail::to($user->email)->send(new UserRegistration($message, $subject, $user));
                } catch (Exception $ex) {
                }
            }
        } else {
            try {
                $template = EmailTemplate::where('name', 'user_verification')->first();
                $subject = $template->subject;
                $message = $template->message;
                $message = str_replace('{{user_name}}', $this->user_info->name, $message);

                Mail::to($this->user_info->email)->send(new UserRegistration($message, $subject, $this->user_info));
            } catch (Exception $ex) {
            }
        }

    }
}
