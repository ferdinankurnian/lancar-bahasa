<?php

use Illuminate\Support\Facades\Route;
use Modules\Testimonial\app\Http\Controllers\TestimonialController;

Route::middleware(['auth:admin', 'translation'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('testimonial', TestimonialController::class)->names('testimonial');
        Route::put('/testimonial/status-update/{id}', [TestimonialController::class, 'statusUpdate'])->name('testimonial.status-update');
    });
