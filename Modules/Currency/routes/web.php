<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\app\Http\Controllers\CurrencyController;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'translation']], function () {
    Route::resource('currency', CurrencyController::class)->names('currency');
});
