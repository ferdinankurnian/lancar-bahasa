<?php

use Illuminate\Support\Facades\Route;
use Modules\Refund\app\Http\Controllers\Admin\RefundController as AdminRefundController;
use Modules\Refund\app\Http\Controllers\RefundController;

Route::group(['middleware' => ['auth:web']], function () {

    Route::resource('refund-request', RefundController::class)->names('refund-request');

});

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'translation']], function () {

    Route::controller(AdminRefundController::class)->group(function () {

        Route::get('/refund-request', 'index')->name('refund-request');
        Route::get('/pending-refund-request', 'pending_refund_request')->name('pending-refund-request');
        Route::get('/rejected-refund-request', 'rejected_refund_request')->name('rejected-refund-request');
        Route::get('/complete-refund-request', 'complete_refund_request')->name('complete-refund-request');
        Route::get('/show-refund-request/{id}', 'show')->name('show-refund-request');
        Route::delete('/delete-refund-request/{id}', 'destroy')->name('delete-refund-request');
        Route::post('/approved-refund-request/{id}', 'approved_refund_request')->name('approved-refund-request');
        Route::post('/reject-refund-request/{id}', 'reject_refund_request')->name('reject-refund-request');

    });
});
