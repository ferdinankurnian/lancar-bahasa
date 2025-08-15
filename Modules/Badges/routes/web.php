<?php

use Illuminate\Support\Facades\Route;
use Modules\Badges\app\Http\Controllers\BadgesController;

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

Route::group(['middleware' => ['auth:admin', 'translation'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::put('registration-badge', [BadgesController::class, 'registrationBadge'])->name('registration-badge');
    Route::resource('badges', BadgesController::class)->names('badges');
});
