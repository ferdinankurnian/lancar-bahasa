<?php

use Illuminate\Support\Facades\Route;
use Modules\Installer\app\Http\Controllers\InstallerController;
use Modules\Installer\app\Http\Controllers\PuchaseVerificationController;
use Modules\Installer\app\Http\Middleware\PurchaseVerifyMiddleware;
use Modules\Installer\app\Http\Middleware\SetupMiddleware;

//all setup route
Route::prefix('setup')->withoutMiddleware(PurchaseVerifyMiddleware::class)->group(function () {
    Route::controller(PuchaseVerificationController::class)->group(function () {
        Route::get('verify', 'index')->name('setup.verify');
        Route::post('verify', 'validatePurchase')->name('setup.checkParchase');
    });
    Route::controller(InstallerController::class)->withoutMiddleware('demo')->group(function () {
        Route::get('requirements', 'requirements')->name('setup.requirements');
        Route::get('database', 'database')->name('setup.database');
        Route::post('database-submit', 'databaseSubmit')->name('setup.database.submit');
        Route::get('account', 'account')->name('setup.account');
        Route::post('account-submit', 'accountSubmit')->name('setup.account.submit');
        Route::get('configuration', 'configuration')->name('setup.configuration');
        Route::post('configuration-submit', 'configurationSubmit')->name('setup.configuration.submit');
        Route::get('smtp', [InstallerController::class, 'smtp'])->name('setup.smtp');
        Route::post('smtp', [InstallerController::class, 'smtpSetup'])->name('setup.smtp.update');
        Route::post('smtp/skip', [InstallerController::class, 'smtpSkip'])->name('setup.smtp.skip');
        Route::get('complete', 'setupComplete')->name('setup.complete');
    });

    Route::get('lunch/{type}', [InstallerController::class, 'launchWebsite'])->name('website.completed')->withoutMiddleware('demo')->withoutMiddleware(SetupMiddleware::class);
});
