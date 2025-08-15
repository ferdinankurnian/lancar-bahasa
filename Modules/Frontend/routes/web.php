<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\app\Http\Controllers\FaqSectionController;
use Modules\Frontend\app\Http\Controllers\HeroSectionController;
use Modules\Frontend\app\Http\Controllers\AboutSectionController;
use Modules\Frontend\app\Http\Controllers\BannerSectionController;
use Modules\Frontend\app\Http\Controllers\SliderSectionController;
use Modules\Frontend\app\Http\Controllers\ContactSectionController;
use Modules\Frontend\app\Http\Controllers\CounterSectionController;
use Modules\Frontend\app\Http\Controllers\NewsLetterSectionController;
use Modules\Frontend\app\Http\Controllers\FeaturedInstructorController;
use Modules\Frontend\app\Http\Controllers\OurFeaturesSectionController;
use Modules\Frontend\app\Http\Controllers\FeaturedCourseSectionController;


Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('hero-section', [HeroSectionController::class, 'index'])->name('hero-section.index');
    Route::put('hero-section', [HeroSectionController::class, 'update'])->name('hero-section.update');
    Route::get('slider-section', [SliderSectionController::class, 'index'])->name('slider-section.index');
    Route::put('slider-section', [SliderSectionController::class, 'update'])->name('slider-section.update');
    Route::get('about-section', [AboutSectionController::class, 'index'])->name('about-section.index');
    Route::put('about-section', [AboutSectionController::class, 'update'])->name('about-section.update');
    Route::get('newsletter-section', [NewsLetterSectionController::class, 'index'])->name('newsletter-section.index');
    Route::put('newsletter-section', [NewsLetterSectionController::class, 'update'])->name('newsletter-section.update');
    Route::get('counter-section', [CounterSectionController::class, 'index'])->name('counter-section.index');
    Route::put('counter-section', [CounterSectionController::class, 'update'])->name('counter-section.update');
    Route::get('faq-section', [FaqSectionController::class, 'index'])->name('faq-section.index');
    Route::put('faq-section', [FaqSectionController::class, 'update'])->name('faq-section.update');
    Route::get('our-features-section', [OurFeaturesSectionController::class, 'index'])->name('our-features-section.index');
    Route::put('our-features-section', [OurFeaturesSectionController::class, 'update'])->name('our-features-section.update');
    Route::get('banner-section', [BannerSectionController::class, 'index'])->name('banner-section.index');
    Route::put('banner-section', [BannerSectionController::class, 'update'])->name('banner-section.update');


    Route::get('courses-by-category/{category_id}', [FeaturedCourseSectionController::class, 'coursesByCategory'])->name('courses-by-category');
    Route::resource('featured-course-section', FeaturedCourseSectionController::class)->only(['index','update']);
    Route::resource('featured-instructor-section', FeaturedInstructorController::class)->only(['edit','update']);
    Route::resource('contact-section', ContactSectionController::class)->only(['index','update']);
});
