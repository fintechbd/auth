<?php

use Fintech\Auth\Http\Controllers\AuthenticatedSessionController;
use Fintech\Auth\Http\Controllers\EmailVerificationController;
use Fintech\Auth\Http\Controllers\PasswordResetController;
use Fintech\Auth\Http\Controllers\RegisteredUserController;
use Fintech\Auth\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
if (Config::get('fintech.auth.enabled')) {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware('guest')
            ->name('register');

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest')
            ->name('login');

        if (config('fintech.auth.self_password_reset')) {

            Route::post('/forgot-password', [PasswordResetController::class, 'store'])
                ->middleware('guest')
                ->name('forgot-password');

            Route::post('/reset-password', [PasswordResetController::class, 'update'])
                ->middleware('guest')
                ->name('reset-password');
        }

        Route::post('/request-otp', [\Fintech\Auth\Http\Controllers\VerificationController::class, 'store'])
            ->name('request-otp');

        Route::post('/verify-otp', [\Fintech\Auth\Http\Controllers\VerificationController::class, 'update'])
            ->name('verify-otp');


        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware(config('fintech.auth.middleware'))
            ->name('logout');

        Route::middleware(config('fintech.auth.middleware'))->group(function () {
            Route::apiResource('users', \Fintech\Auth\Http\Controllers\UserController::class);
            Route::post('users/{user}/restore', [\Fintech\Auth\Http\Controllers\UserController::class, 'restore'])->name('users.restore');

            Route::apiResource('roles', \Fintech\Auth\Http\Controllers\RoleController::class);
            Route::post('roles/{role}/restore', [\Fintech\Auth\Http\Controllers\RoleController::class, 'restore'])->name('roles.restore');

            Route::apiResource('permissions', \Fintech\Auth\Http\Controllers\PermissionController::class);
            Route::post('permissions/{permission}/restore', [\Fintech\Auth\Http\Controllers\PermissionController::class, 'restore'])->name('permissions.restore');

            //        Route::apiResource('teams', \Fintech\Auth\Http\Controllers\TeamController::class);
            //        Route::post('teams/{team}/restore', [\Fintech\Auth\Http\Controllers\TeamController::class, 'restore'])->name('teams.restore');

            Route::apiResource('settings', \Fintech\Auth\Http\Controllers\SettingController::class)->only(['index', 'store']);
        });
    });
}
