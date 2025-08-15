<?php

namespace Modules\NewsLetter\app\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Traits\GetGlobalInformationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\GlobalSetting\app\Models\EmailTemplate;
use Modules\NewsLetter\app\Emails\NewsLetterVerifyMail;

class NewsLetterVerifyJob implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    private $newsletter_info;

    public function __construct($newsletter_info)
    {
        $this->newsletter_info = $newsletter_info;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $this->set_mail_config();

        try {
            $template = EmailTemplate::where('name', 'subscribe_notification')->first();
            $message = $template->message;
            $subject = $template->subject;
            Mail::to($this->newsletter_info->email)->send(new NewsLetterVerifyMail($this->newsletter_info, $subject, $message));
        } catch (Exception $ex) {
        }

    }
}
