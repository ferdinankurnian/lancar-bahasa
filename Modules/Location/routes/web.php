<?php

use Illuminate\Support\Facades\Route;
use Modules\Location\app\Http\Controllers\CityController;
use Modules\Location\app\Http\Controllers\CountryController;
use Modules\Location\app\Http\Controllers\StateController;

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
    Route::resource('country', CountryController::class)->names('country');
});
