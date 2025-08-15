<?php

namespace Modules\Refund\app\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RefundRejectMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_subject;

    public $mail_template;

    public function __construct($mail_subject, $mail_template)
    {
        $this->mail_subject = $mail_subject;
        $this->mail_template = $mail_template;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject($this->mail_subject)->view('refund::admin.refund_reject_mail', ['mail_template' => $this->mail_template]);
    }
}
