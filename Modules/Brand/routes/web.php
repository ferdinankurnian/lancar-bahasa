<?php

use Illuminate\Support\Facades\Route;
use Modules\Brand\app\Http\Controllers\BrandController;

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
    Route::put('brand/status-update/{id}', [BrandController::class, 'statusUpdate'])->name('brand.status-update');
    Route::resource('brand', BrandController::class)->names('brand');
});
