<?php

use Illuminate\Support\Facades\Route;
use Modules\CertificateBuilder\app\Http\Controllers\CertificateBuilderController;

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
    Route::post('certificate-builder/item/update', [CertificateBuilderController::class, 'updateItem'])->name('certificate-builder.item.update');
    Route::resource('certificate-builder', CertificateBuilderController::class)->names('certificate-builder');
});
