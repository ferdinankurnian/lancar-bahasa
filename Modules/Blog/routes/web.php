<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\app\Http\Controllers\BlogCategoryController;
use Modules\Blog\app\Http\Controllers\BlogCommentController;
use Modules\Blog\app\Http\Controllers\BlogController;

Route::middleware(['auth:admin', 'translation'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('blogs', BlogController::class)->names('blogs');
        Route::put('/blogs/status-update/{id}', [BlogController::class, 'statusUpdate'])->name('blogs.status-update');

        Route::resource('blog-category', BlogCategoryController::class)->names('blog-category')->except('show');
        Route::put('/blog-category/status-update/{id}', [BlogCategoryController::class, 'statusUpdate'])->name('blog-category.status-update');

        Route::resource('blog-comment', BlogCommentController::class)->names('blog-comment')->only(['index', 'show', 'destroy']);
        Route::put('/blog-comment/status-update/{id}', [BlogCommentController::class, 'statusUpdate'])->name('blog-comment.status-update');
    });
