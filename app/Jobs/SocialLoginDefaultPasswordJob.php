<?php

namespace App\Jobs;

use App\Mail\SocialLoginDefaultPasswordMail;
use App\Models\User;
use App\Traits\GetGlobalInformationTrait;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SocialLoginDefaultPasswordJob implements ShouldQueue
{
    use Dispatchable, GetGlobalInformationTrait, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private User $user, private string $password)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->set_mail_config();

        try {
            Mail::to($this->user->email)->send(new SocialLoginDefaultPasswordMail($this->user, $this->password));
        } catch (Exception $ex) {
            if (app()->isLocal()) {
                Log::error($ex->getMessage());
            }
        }
    }
}
