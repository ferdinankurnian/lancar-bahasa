<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\app\Http\Controllers\CustomerController;

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
    Route::controller(CustomerController::class)->group(function () {

        Route::get('all-customers', 'index')->name('all-customers');
        Route::get('all-instructors', 'allInstructors')->name('all-instructors');
        Route::get('active-customers', 'active_customer')->name('active-customers');
        Route::get('non-verified-customers', 'non_verified_customers')->name('non-verified-customers');
        Route::get('banned-customers', 'banned_customers')->name('banned-customers');
        Route::get('customer-show/{id}', 'show')->name('customer-show');
        Route::put('customer-info-update/{id}', 'update')->name('customer-info-update');
        Route::put('customer-bio-update/{id}', 'bioUpdate')->name('customer-bio-update');

        Route::get('customer-experience-modal/{id}', 'experienceModal')->name('customer-experience-modal');
        Route::post('customer-experience-store/{id}', 'experienceStore')->name('customer-experience-store');
        Route::get('customer-edit-experience-modal/{id}', 'editExperienceModal')->name('customer-edit-experience-modal');
        Route::put('customer-experience-update/{id}', 'experienceUpdate')->name('customer-experience-update');
        Route::delete('customer-experience-destroy/{id}', 'experienceDestroy')->name('customer-experience-destroy');
        
        Route::get('customer-education-modal/{id}', 'educationModal')->name('customer-education-modal');
        Route::post('customer-education-store/{id}', 'educationStore')->name('customer-education-store');
        Route::get('customer-edit-education-modal/{id}', 'editEducationModal')->name('customer-edit-education-modal');
        Route::put('customer-education-update/{id}', 'educationUpdate')->name('customer-education-update');
        Route::delete('customer-education-destroy/{id}', 'educationDestroy')->name('customer-education-destroy');

        Route::put('customer-location-update/{id}', 'locationUpdate')->name('customer-location-update');
        Route::put('customer-social-update/{id}', 'socialUpdate')->name('customer-Social-update');





        Route::put('customer-password-change/{id}', 'password_change')->name('customer-password-change');
        Route::post('send-banned-request/{id}', 'send_banned_request')->name('send-banned-request');
        Route::post('send-verify-request/{id}', 'send_verify_request')->name('send-verify-request');
        Route::post('send-verify-request-to-all', 'send_verify_request_to_all')->name('send-verify-request-to-all');
        Route::post('send-mail-to-customer/{id}', 'send_mail_to_customer')->name('send-mail-to-customer');
        Route::get('send-bulk-mail', 'send_bulk_mail')->name('send-bulk-mail');
        Route::post('send-bulk-mail-to-all', 'send_bulk_mail_to_all')->name('send-bulk-mail-to-all');
        Route::delete('customer-delete/{id}', 'destroy')->name('customer-delete');

    });

});
