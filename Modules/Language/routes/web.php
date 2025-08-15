<?php

use Illuminate\Support\Facades\Route;
use Modules\Language\app\Http\Controllers\LanguageController;
use Modules\Language\app\Http\Controllers\StaticLanguageController;
use Modules\Language\app\Http\Controllers\TranslationController;

Route::middleware(['auth:admin', 'translation'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::controller(LanguageController::class)->group(function () {
            Route::put('languages/update-status/{language}', 'updateStatus')->name('languages.update-status');
        });

        Route::resource('languages', LanguageController::class)
            ->names('languages')
            ->except('show');

        Route::controller(StaticLanguageController::class)->group(function () {
            Route::get('languages/update-static-lang/{code}', 'editStaticLanguages')->name('languages.edit-static-languages');
            Route::post('languages/update-static-lang/{code}', 'updateStaticLanguages')->name('languages.update-static-languages');
        });

        Route::post('languages/update-single', [TranslationController::class, 'translateSingleText'])->name('languages.update.single');
        Route::post('languages/translate-all-language', [TranslationController::class, 'translateAll'])->name('languages.translateAll');
    });
