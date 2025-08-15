<?php

use Illuminate\Support\Facades\Route;
use Modules\InstructorRequest\app\Http\Controllers\InstructorRequestController;
use Modules\InstructorRequest\app\Http\Controllers\InstructorRequestSettingController;

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin', 'translation']], function () {
    Route::resource('instructor-request', InstructorRequestController::class)->names('instructor-request');
    Route::resource('instructor-request-setting', InstructorRequestSettingController::class)->names('instructor-request-setting');

});
