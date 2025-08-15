<?php

namespace Modules\Language\app\Traits;

use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Stichoza\GoogleTranslate\GoogleTranslate;

trait GenerateTranslationTrait
{
    /**
     * use this trait to automatically generate translation fields
     * for models and save to database
     */
    protected function generateTranslations(
        TranslationModels $translationModel,
        object $model,
        string $forignKey,
        object $request,
        bool $translateField = false,
        array $customFields = [],
        ?string $translationModelCustom = null,
    ) {
        if (! $translationModelCustom) {
            $translationClass = $translationModel->value;
        }

        $languages = Language::all();
        try {
            $validated = $request->validated();
        } catch (\Throwable $th) {
            $validated = $request->all();
        }

        foreach ($languages as $language) {
            $translationModel = new $translationClass();
            $translationModel->lang_code = $language->code;
            $translationModel->$forignKey = $model->id;
            $translationModel->fill($validated);
            if ($customFields) {
                if ($translateField) {
                    try {
                        $tr = new GoogleTranslate($language->code);
                    } catch (\Throwable $th) {
                        $tr = false;
                    }
                }
                foreach ($customFields as $key => $value) {
                    $code = $request->code ? $request->code : $request->lang_code ?? '';
                    if ($language->code !== $code) {
                        $afterTrans = $tr ? $tr->translate($value) : $value;
                        $translationModel->$key = $afterTrans ?? $value;
                    } else {
                        $translationModel->$key = $value;
                    }
                }
            }
            $translationModel->save();
        }
    }

    protected function updateTranslations(
        object $model,
        object $request,
        array $validatedData,
        array $customFields = []
    ) {
        $code = $request->code ?? $request->lang_code;

        $translation = $model->translations()->where('lang_code', $code)->first();

        if ($customFields) {
            foreach ($customFields as $key => $value) {
                $validatedData[$key] = $value;
            }
        }

        if ($translation) {
            $translation->update($validatedData);
        } else {
            $model->translations()->create(array_merge(['lang_code' => $code], $validatedData));
        }
    }
}
