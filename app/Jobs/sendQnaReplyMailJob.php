<?php

namespace App\Jobs;

use App\Mail\sendQnaReplyMail;
use App\Traits\GetGlobalInformationTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class sendQnaReplyMailJob implements ShouldQueue {
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    public $mail_email;
    public $mail_subject;

    public $mail_message;

    public $link;

    public function __construct($mail_email, $mail_subject, $mail_message, $link) {
        $this->mail_email = $mail_email;
        $this->mail_subject = $mail_subject;
        $this->mail_message = $mail_message;
        $this->link = $link;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        $this->set_mail_config();

        try {
            Mail::to($this->mail_email)->send(new sendQnaReplyMail($this->mail_subject, $this->mail_message, $this->link));
        } catch (\Exception $ex) {
        }
    }
}
