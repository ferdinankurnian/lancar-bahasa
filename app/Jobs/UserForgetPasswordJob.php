<?php

namespace App\Jobs;

use App\Mail\UserForgetPassword;
use App\Traits\GetGlobalInformationTrait;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Modules\GlobalSetting\app\Models\EmailTemplate;

class UserForgetPasswordJob implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    public $from_user;

    public $mail_template_path;

    public function __construct($from_user, $mail_template_path = 'auth')
    {
        $this->from_user = $from_user;
        $this->mail_template_path = $mail_template_path;
    }

    public function handle(): void
    {
        $this->set_mail_config();

        try {
            $template = EmailTemplate::where('name', 'password_reset')->first();
            $subject = $template->subject;
            $message = $template->message;
            $message = str_replace('{{user_name}}', $this->from_user->name, $message);
            Mail::to($this->from_user->email)->send(new UserForgetPassword($message, $subject, $this->from_user, $this->mail_template_path));
        } catch (Exception $ex) {
        }

    }
}
