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
use Modules\Refund\app\Emails\RefundApprovalMail;

class RefundApprovalJob implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    private $mail_refund_amount;

    private $mail_user;

    public function __construct($mail_refund_amount, $mail_user)
    {
        $this->mail_refund_amount = $mail_refund_amount;
        $this->mail_user = $mail_user;
    }

    public function handle(): void
    {
        $this->set_mail_config();

        $template = EmailTemplate::where('name', 'approved_refund')->first();
        $subject = $template->subject;
        $message = $template->message;
        $message = str_replace('{{user_name}}', $this->mail_user->name, $message);
        $message = str_replace('{{refund_amount}}', $this->mail_refund_amount, $message);

        try {
            Mail::to($this->mail_user->email)->send(new RefundApprovalMail($subject, $message));
        } catch (Exception $ex) {
        }
    }
}
