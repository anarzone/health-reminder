<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ReminderController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\ArticleController;
use App\Http\Controllers\V1\Auth\AuthController;


Route::prefix('v1')->group(function () {

    Route::prefix('auth')->name('auth')->group(function () {
        Route::post('login',[AuthController::class,'login'])->name('login');
        Route::post('logout',[AuthController::class,'logout'])->name('logout');
    });

    Route::prefix('reminders')->name('reminders.')->group(function () {
        Route::get('/', [ReminderController::class, 'index'])->name('index');
        Route::get('{reminderId}', [ReminderController::class, 'edit'])->name('edit');
        Route::delete('{reminderId}', [ReminderController::class, 'delete'])->name('delete');
        Route::post('store', [ReminderController::class, 'store'])->name('store');
        Route::patch('{reminderId}', [ReminderController::class, 'update'])->name('update');

        Route::prefix('assets')->name('assets.')->group(function () {
            Route::get('colors',[ReminderController::class,'getColors'])->name('colors');
            Route::get('shapes',[ReminderController::class,'getShapes'])->name('shapes');
        });
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::post('store', [UserController::class, 'store'])->name('store');
    });

    Route::prefix('articles')->name('articles.')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('index');
        Route::get('{articleId}', [ArticleController::class, 'show'])->name('show');
    });

});
