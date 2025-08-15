<?php

namespace Modules\InstructorRequest\app\Jobs;

use App\Traits\GetGlobalInformationTrait;
use App\Traits\MailSenderTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\InstructorRequest\app\Emails\InstructorRequestStatusUpdateMail;

class InstructorRequestMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GetGlobalInformationTrait;

    public $email;
    public $subject;
    public $template;
    /**
     * Create a new job instance.
     */
    public function __construct($email, $subject, $template)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->template = $template;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->set_mail_config();
        Mail::to($this->email)->send(new InstructorRequestStatusUpdateMail($this->subject, $this->template));
    }
}
