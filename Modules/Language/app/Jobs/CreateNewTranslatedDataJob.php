<?php

namespace Modules\Language\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\Language\app\Traits\TranslateableModelsTrait;

class CreateNewTranslatedDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, TranslateableModelsTrait;

    public function __construct(
        protected $defaultCode,
        protected $newCode,
        protected $translateableModel
    ) {
    }

    public function handle(): void
    {
        $countCreatedModels = 0;
        $oldModels = $this->translateableModel::where('lang_code', $this->defaultCode)->get();
        $ignoredColumns = $this->getIgnoredColumsArray();

        foreach ($oldModels as $oldModel) {
            if (! $this->translateableModel::where(['id' => $oldModel->id, 'lang_code' => $this->newCode])->exists()) {
                $newModel = new $this->translateableModel();
                $newModel->lang_code = $this->newCode;

                foreach ($oldModel->toArray() as $key => $value) {
                    if (! in_array($key, $ignoredColumns)) {
                        $newModel->$key = $value;
                    }
                }

                $newModel->save();
                $countCreatedModels++;
            }
        }

        Log::info("Total {$countCreatedModels} new records have been saved into {$this->translateableModel} model for {$this->newCode} Language using Queue");
    }
}
