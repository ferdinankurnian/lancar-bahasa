<?php

namespace Modules\Language\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateTranslationCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected $oldCode,
        protected $newCode,
        protected $translateableModel
    ) {
    }

    public function handle(): void
    {
        $countCreatedModels = 0;
        $oldModels = $this->translateableModel::where('lang_code', $this->oldCode)->get();
        foreach ($oldModels as $oldModel) {
            $oldModel->lang_code = $this->newCode;
            $oldModel->save();
            $countCreatedModels++;
        }
        Log::info("Total { $countCreatedModels } new recordes has been updated on {$this->translateableModel} model for {$this->newCode} Language using Queue");
    }
}
