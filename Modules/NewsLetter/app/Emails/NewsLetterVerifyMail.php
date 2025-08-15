<?php

namespace Modules\NewsLetter\app\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsLetterVerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_subject;

    public $mail_template;

    public $newsletter_info;

    public function __construct($newsletter_info, $mail_subject, $mail_template)
    {
        $this->mail_subject = $mail_subject;
        $this->mail_template = $mail_template;
        $this->newsletter_info = $newsletter_info;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject($this->mail_subject)->view('newsletter::verify_mail_template', ['newsletter_info' => $this->newsletter_info,
            'mail_template' => $this->mail_template]);

    }
}
