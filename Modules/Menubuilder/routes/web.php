<?php

use Illuminate\Support\Facades\Route;
use Modules\Menubuilder\app\Http\Controllers\MenubuilderController;

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
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['translation']], function () {
    Route::get('menu-builder', [MenubuilderController::class,'index'])->name('menubuilder.index');

    // Routes for menus
    Route::post('menus/create', [MenubuilderController::class,'createMenu'])->name('menus.create');
    Route::post('menus/update', [MenubuilderController::class,'updateMenu'])->name('menus.update');
    Route::post('menus/delete', [MenubuilderController::class,'deleteMenu'])->name('menus.delete');

    // Routes for menu items
    Route::post('menu-items/create', [MenubuilderController::class,'addMenuItem'])->name('menus.items.create');
    Route::post('menu-items/update', [MenubuilderController::class,'updateMenuItem'])->name('menus.items.update');
    Route::post('menu-items/delete', [MenubuilderController::class,'deleteMenuItem'])->name('menus.items.delete');

});