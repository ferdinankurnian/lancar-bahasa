<?php

namespace Modules\ContactMessage\app\Jobs;

use App\Traits\GetGlobalInformationTrait;
use Cache;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use Modules\ContactMessage\app\Emails\ContactMessageMail;
use Modules\GlobalSetting\app\Models\EmailTemplate;

class ContactMessageSendJob implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    private $contact_message;

    public function __construct($contact_message)
    {
        $this->contact_message = $contact_message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->set_mail_config();

        try {
            $template = EmailTemplate::where('name', 'contact_mail')->first();
            $subject = $template->subject;
            $message = $template->message;
            $message = str_replace('{{name}}', $this->contact_message->name, $message);
            $message = str_replace('{{email}}', $this->contact_message->email, $message);
            $message = str_replace('{{phone}}', $this->contact_message->phone, $message);
            $message = str_replace('{{subject}}', $this->contact_message->subject, $message);
            $message = str_replace('{{message}}', $this->contact_message->message, $message);

            $email_setting = Cache::get('setting');

            Mail::to($email_setting->contact_message_receiver_mail)->send(new ContactMessageMail($subject, $message));
        } catch (Exception $ex) {
        }
    }
}
