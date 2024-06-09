<?php

use App\Http\Controllers\Api\Auth\AuthenticatedUserController;
use App\Http\Controllers\Api\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('api.register');

Route::post('login', [AuthenticatedUserController::class, 'store'])
    ->middleware('guest')
    ->name('api.login');

Route::post('logout', [AuthenticatedUserController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('api.logout');

Route::post('forgot-password', [PasswordResetController::class, 'store'])
    ->middleware('guest')
    ->name('api.forgot-password');

Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('api.reset-password');


Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->name('api.verification-notification');

Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth:sanctum', 'signed', 'throttle:6,1'])
    ->name('api.verification.verify');
