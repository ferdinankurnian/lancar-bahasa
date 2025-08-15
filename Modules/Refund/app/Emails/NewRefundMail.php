<?php

namespace Modules\Refund\app\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRefundMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_subject;

    public $mail_template;

    public $refund_request;

    public function __construct($mail_subject, $mail_template, $refund_request)
    {
        $this->mail_subject = $mail_subject;
        $this->mail_template = $mail_template;
        $this->refund_request = $refund_request;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject($this->mail_subject)->view('refund::new_refund_mail', ['mail_template' => $this->mail_template, 'refund_request' => $this->refund_request]);
    }
}
