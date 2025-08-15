<?php

namespace Modules\Language\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteTranslationDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $code,
        protected $translateableModel
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $deleteModels = $this->translateableModel::where('lang_code', $this->code);
        $countCreatedModels = $deleteModels->count();
        $deleteModels->delete();
        Log::info("Total { $countCreatedModels } recordes has been deleted into {$this->translateableModel} model for {$this->code} Language");
    }
}
