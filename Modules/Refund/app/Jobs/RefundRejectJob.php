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
use Modules\Refund\app\Emails\RefundRejectMail;

class RefundRejectJob implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    private $mail_subject;

    private $mail_template;

    private $mail_user;

    public function __construct($mail_subject, $mail_template, $mail_user)
    {
        $this->mail_subject = $mail_subject;
        $this->mail_template = $mail_template;
        $this->mail_user = $mail_user;
    }

    public function handle(): void
    {
        $this->set_mail_config();

        $mail_description = str_replace('[[name]]', $this->mail_user->name, $this->mail_template);

        try {
            Mail::to($this->mail_user->email)->send(new RefundRejectMail($this->mail_subject, $mail_description));
        } catch (Exception $ex) {
        }

    }
}
