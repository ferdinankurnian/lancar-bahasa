<?php

use Illuminate\Support\Facades\Route;
use Modules\PageBuilder\app\Http\Controllers\PageBuilderController;

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

    Route::put('/page-builder/status-update/{id}', [PageBuilderController::class, 'statusUpdate'])->name('page-builder.status-update');
    Route::resource('page-builder', PageBuilderController::class)->names('page-builder');
});
