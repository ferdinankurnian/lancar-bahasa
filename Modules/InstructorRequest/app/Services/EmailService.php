<?php

namespace Modules\InstructorRequest\app\Services;

use App\Traits\MailSenderTrait;
use Illuminate\Support\Facades\Mail;
use Modules\GlobalSetting\app\Models\EmailTemplate;
use Modules\InstructorRequest\app\Emails\InstructorRequestStatusUpdateMail;
use Modules\InstructorRequest\app\Jobs\InstructorRequestMailJob;

class EmailService
{
  use MailSenderTrait;
  private const TEMPLATE_NAMES = [
    'approved' => 'instructor_request_approved',
    'rejected' => 'instructor_request_rejected',
    'pending' => 'instructor_request_pending',
  ];

  function handleInstructorRequestStatusMailSending(array $mailObject): void
  {
    self::setMailConfig();

    // Get email template
    $templateName = self::TEMPLATE_NAMES[$mailObject['status']];
    $template = EmailTemplate::where('name', $templateName)->firstOrFail();

    // Prepare email content
    $message = str_replace('{{user_name}}', $mailObject['user_name'], $template->message);

    if (self::isQueable()) {
      InstructorRequestMailJob::dispatch($mailObject['user_email'], $template->subject, $message);
    } else {
      Mail::to($mailObject['user_email'])->send(new InstructorRequestStatusUpdateMail($template->subject, $message));
    }
  }

}
