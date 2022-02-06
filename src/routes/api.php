<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ReminderController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\ArticleController;
use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Auth\SocialController;
use App\Http\Controllers\V1\Auth\PasswordRecoverController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('login',[AuthController::class,'login'])->name('login');
        Route::post('logout',[AuthController::class,'logout'])->name('logout');
//        Route::get('{provider}',[SocialController::class,'handleRedirect'])->name('handleRedirect');
//        Route::get('{provider}/callback',[SocialController::class,'handleCallback'])->name('handleCallback');
        Route::post('{provider}',[SocialController::class,'handleProviders'])->name('handleProviders');

        Route::post('forgot-password', [PasswordRecoverController::class,'sendResetEmail'])->name('password.forgot');
        Route::post('verify-password', [PasswordRecoverController::class,'verifyPassword'])->name('password.verify');
        Route::post('reset-password', [PasswordRecoverController::class,'resetPassword'])->name('password.reset');
    });

    Route::prefix('reminders')->name('reminders.')->group(function () {
        Route::get('/', [ReminderController::class, 'index'])->name('index');
        Route::get('{reminderId}', [ReminderController::class, 'edit'])->name('edit');
        Route::delete('{reminderId}', [ReminderController::class, 'delete'])->name('delete');
        Route::post('store', [ReminderController::class, 'store'])->name('store');
        Route::patch('{reminderId}', [ReminderController::class, 'update'])->name('update');
        Route::patch('{reminderId}/status', [ReminderController::class, 'updateStatus'])->name('status.update');
        Route::patch('{reminderId}/timeSchedules/{timeScheduleId}/status', [ReminderController::class, 'updateTimeScheduleStatus'])
            ->name('timeSchedule.status.update');

        Route::prefix('assets')->name('assets.')->group(function () {
            Route::get('colors',[ReminderController::class,'getColors'])->name('colors');
            Route::get('shapes',[ReminderController::class,'getShapes'])->name('shapes');
        });
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::prefix('profile')->name('profile')->group(function () {
            Route::get('edit',[UserController::class, 'edit'])->name('edit');
            Route::patch('update', [UserController::class, 'update'])->name('update');
        });

        Route::post('store', [UserController::class, 'store'])->name('store');
    });

    Route::prefix('articles')->name('articles.')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('index');
        Route::get('{articleId}', [ArticleController::class, 'show'])->name('show');
    });

});
