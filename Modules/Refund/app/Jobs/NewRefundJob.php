<?php

namespace Modules\Refund\app\Jobs;

use App\Traits\GetGlobalInformationTrait;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Modules\GlobalSetting\app\Models\EmailTemplate;
use Modules\Refund\app\Emails\NewRefundMail;

class NewRefundJob implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    private $mail_user;

    private $refund_request;

    public function __construct($mail_user, $refund_request)
    {
        $this->mail_user = $mail_user;
        $this->refund_request = $refund_request;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->set_mail_config();

        $template = EmailTemplate::where('name', 'new_refund')->first();
        $subject = $template->subject;
        $message = $template->message;
        $message = str_replace('{{user_name}}', $this->mail_user->name, $message);

        try {
            Mail::to($this->mail_user->email)->send(new NewRefundMail($subject, $message, $this->refund_request));
        } catch (Exception $ex) {
        }
    }
}
