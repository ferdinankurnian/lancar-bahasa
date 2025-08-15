<?php

use Illuminate\Support\Facades\Route;
use Modules\BasicPayment\app\Http\Controllers\BasicPaymentController;
use Modules\BasicPayment\app\Http\Controllers\FrontPaymentController;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin','translation']], function () {

    Route::controller(BasicPaymentController::class)->group(function () {

        Route::get('basicpayment', 'basicpayment')->name('basicpayment');
        Route::put('update-stripe', 'update_stripe')->name('update-stripe');
        Route::put('update-paypal', 'update_paypal')->name('update-paypal');
        Route::put('update-bank-payment', 'update_bank_payment')->name('update-bank-payment');
        Route::put('update-midtrans', 'update_midtrans')->name('update-midtrans');

    });
});

Route::get('basicpayment/paypal-success-payment', [FrontPaymentController::class, 'paypal_success'])->name('basicpayment.paypal-success-payment');
