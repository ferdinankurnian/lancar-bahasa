<?php

use Illuminate\Support\Facades\Route;
use Modules\NewsLetter\app\Http\Controllers\Admin\NewsLetterController as AdminNewsLetterController;
use Modules\NewsLetter\app\Http\Controllers\NewsLetterController;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'translation']], function () {
    Route::get('subscriber-list', [AdminNewsLetterController::class, 'index'])->name('subscriber-list');
    Route::delete('subscriber-delete/{id}', [AdminNewsLetterController::class, 'destroy'])->name('subscriber-delete');
    Route::get('send-mail-to-newsletter', [AdminNewsLetterController::class, 'create'])->name('send-mail-to-newsletter');
    Route::post('send-mail-to-subscriber', [AdminNewsLetterController::class, 'store'])->name('send-mail-to-subscriber');
});

Route::post('newsletter-request', [NewsLetterController::class, 'newsletter_request'])->name('newsletter-request');
Route::get('newsletter-verification/{token}', [NewsLetterController::class, 'newsletter_verification'])->name('newsletter-verification');
