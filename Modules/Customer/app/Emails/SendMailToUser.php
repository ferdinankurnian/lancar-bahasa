<?php

namespace Modules\Customer\app\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToUser extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_subject;

    public $mail_message;

    public function __construct($mail_message, $mail_subject)
    {
        $this->mail_subject = $mail_subject;
        $this->mail_message = $mail_message;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        $mail_subject = $this->mail_subject;
        $mail_message = $this->mail_message;

        return $this->subject($this->mail_subject)->view('customer::mail_template_for_customr_mail', compact('mail_subject','mail_message'));
    }
}
