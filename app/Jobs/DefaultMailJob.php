<?php

namespace App\Jobs;

use App\Mail\DefaultMail;
use App\Mail\InstructorQuickContactMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DefaultMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mailData;
    public $subject;
    public $messageTemplate;
    /**
     * Create a new job instance.
     */
    public function __construct($mailData, $messageTemplate)
    {
        $this->mailData = $mailData;
        $this->messageTemplate = $messageTemplate;
        $this->subject = $this->mailData['subject'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
          Mail::to($this->mailData['email'])->send(new DefaultMail($this->mailData, $this->messageTemplate));
    }
}
