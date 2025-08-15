<?php

use Illuminate\Support\Facades\Route;
use Modules\ContactMessage\app\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use Modules\ContactMessage\app\Http\Controllers\ContactMessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'translation']], function () {
    Route::get('contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages');
    Route::get('contact-message/{id}', [AdminContactMessageController::class, 'show'])->name('contact-message');
    Route::delete('contact-message-delete/{id}', [AdminContactMessageController::class, 'destroy'])->name('contact-message-delete');
});

Route::get('send-contact-message', [ContactMessageController::class, 'store'])->name('send-contact-message');
