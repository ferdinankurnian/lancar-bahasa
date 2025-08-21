<?php

use Illuminate\Support\Facades\Route;
use Modules\Midtrans\app\Http\Controllers\MidtransController;

// Admin routes for Midtrans settings
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('midtrans', [MidtransController::class, 'index'])->name('admin.midtrans.index');
    Route::post('midtrans', [MidtransController::class, 'update'])->name('admin.midtrans.update');
});

// Route for creating Midtrans transaction (Snap Token)
Route::post('/midtrans/create-transaction', [MidtransController::class, 'createTransaction'])
    ->name('midtrans.create-transaction')
    ->middleware('auth');

// Route for the browser to return to after payment for secure processing
Route::get('/midtrans/finalize', [MidtransController::class, 'finalizeTransaction'])
    ->name('midtrans.finalize')
    ->middleware('auth');

// Route for server-to-server notification callback from Midtrans
Route::post('/midtrans/notify', [MidtransController::class, 'notify'])->name('midtrans.notify');