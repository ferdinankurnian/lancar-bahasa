<?php

namespace Modules\Customer\app\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Traits\GetGlobalInformationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Customer\app\Emails\UserBanned;

class SendUserBannedMailJob implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    private $mail_subject;

    private $mail_message;

    private $user_info;

    public function __construct($mail_message, $mail_subject, $user_info)
    {
        $this->mail_subject = $mail_subject;
        $this->mail_message = $mail_message;
        $this->user_info = $user_info;
    }

    public function handle(): void
    {
        try {
            $this->set_mail_config();
            Mail::to($this->user_info->email)->send(new UserBanned($this->mail_message, $this->mail_subject));
        } catch (Exception $ex) {
            logger($ex);
        }
    }
}
