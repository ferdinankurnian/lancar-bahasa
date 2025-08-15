<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\app\Http\Controllers\FaqController;

Route::middleware(['auth:admin', 'translation'])
    ->name('admin.')
    ->prefix('admin')
    ->group(
        function () {
            Route::resource('faq', FaqController::class)->names('faq');
            Route::put('/faq/status-update/{id}', [FaqController::class, 'statusUpdate'])->name('faq.status-update');
        }
    );
