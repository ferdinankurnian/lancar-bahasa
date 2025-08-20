<?php

use Illuminate\Support\Facades\Route;
use Modules\Midtrans\app\Http\Controllers\MidtransController;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('midtrans', [MidtransController::class, 'index'])->name('admin.midtrans.index');
    Route::post('midtrans', [MidtransController::class, 'update'])->name('admin.midtrans.update');
});

// Routes for payment processing
Route::post('/midtrans/process', [MidtransController::class, 'process'])->name('midtrans.process');
Route::post('/midtrans/notify', [MidtransController::class, 'notify'])->name('midtrans.notify');

// Redirect routes from Midtrans
Route::get('/midtrans/finish', [MidtransController::class, 'finish'])->name('midtrans.finish');
Route::get('/midtrans/unfinish', [MidtransController::class, 'unfinish'])->name('midtrans.unfinish');
Route::get('/midtrans/error', [MidtransController::class, 'error'])->name('midtrans.error');

// Route for creating Midtrans transaction (Snap Token)
Route::post('/midtrans/create-transaction', [MidtransController::class, 'createTransaction'])->name('midtrans.create-transaction');
