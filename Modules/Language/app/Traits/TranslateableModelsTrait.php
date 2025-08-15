<?php

namespace Modules\Language\app\Traits;

use Modules\Language\app\Enums\TranslationModels;

trait TranslateableModelsTrait
{
    public function getTranslateableModelsArray(): array
    {
        return TranslationModels::getAll();
    }

    public function getIgnoredColumsArray(): array
    {
        return TranslationModels::igonreColumns();
    }
}
