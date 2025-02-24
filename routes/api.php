<?php

use Fintech\Auth\Http\Controllers\AccountDeleteController;
use Fintech\Auth\Http\Controllers\AuditController;
use Fintech\Auth\Http\Controllers\AuthenticatedController;
use Fintech\Auth\Http\Controllers\Charts\RegisteredUserSummaryController;
use Fintech\Auth\Http\Controllers\Charts\UserRoleSummaryController;
use Fintech\Auth\Http\Controllers\Charts\UserStatusSummaryController;
use Fintech\Auth\Http\Controllers\FavouriteController;
use Fintech\Auth\Http\Controllers\LoginAttemptController;
use Fintech\Auth\Http\Controllers\OneTimePinController;
use Fintech\Auth\Http\Controllers\PasswordController;
use Fintech\Auth\Http\Controllers\PermissionController;
use Fintech\Auth\Http\Controllers\ProfileController;
use Fintech\Auth\Http\Controllers\PulseCheckController;
use Fintech\Auth\Http\Controllers\RegisterController;
use Fintech\Auth\Http\Controllers\RoleController;
use Fintech\Auth\Http\Controllers\RolePermissionController;
use Fintech\Auth\Http\Controllers\SettingController;
use Fintech\Auth\Http\Controllers\UserController;
use Fintech\Auth\Http\Controllers\VerifyIdDocumentController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "API" middleware group. Enjoy building your API!
|
*/
if (Config::get('fintech.auth.enabled')) {
    Route::prefix(config('fintech.auth.root_prefix', 'api/'))->middleware(['api'])->group(function () {
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('pulse-check', PulseCheckController::class)
                ->name('pulse-check');

            Route::post('/register', RegisterController::class)
                ->middleware('guest')
                ->name('register');

            Route::post('/login', [AuthenticatedController::class, 'login'])
                ->middleware(['guest', 'logged_in_at'])
                ->name('login');

            Route::post('/logout', [AuthenticatedController::class, 'logout'])
                ->middleware(config('fintech.auth.middleware'))
                ->middleware('logged_out_at')
                ->name('logout');

            if (config('fintech.auth.self_password_reset')) {

                Route::post('/forgot-password', [PasswordController::class, 'forgot'])
                    ->middleware('guest')
                    ->name('forgot-password');

                Route::post('/reset-password', [PasswordController::class, 'reset'])
                    ->middleware('guest')
                    ->name('reset-password');
            }

            Route::post('/request-otp', [OneTimePinController::class, 'request'])
                ->name('request-otp');

            Route::post('/verify-otp', [OneTimePinController::class, 'verify'])
                ->name('verify-otp');

            Route::post('id-doc-verification', VerifyIdDocumentController::class)
                ->name('id-doc-types.verification');

            Route::post('user-verification', [UserController::class, 'verification'])
                ->name('users.verification');

            Route::middleware(config('fintech.auth.middleware'))->group(function () {

                Route::post('update-password', [PasswordController::class, 'updatePassword'])
                    ->name('update-password');

                Route::post('update-pin', [PasswordController::class, 'updatePin'])
                    ->name('update-pin');

                Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');

                Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

                Route::apiResource('users', UserController::class);
                //            Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');

                Route::post('users/change-status', [UserController::class, 'changeStatus'])
                    ->name('users.change-status');

                Route::post('users/{user}/reset/{field}', [UserController::class, 'reset'])
                    ->name('users.reset-password-pin')
                    ->whereIn('field', ['pin', 'password', 'both']);

                Route::apiResource('roles', RoleController::class);

                Route::apiResource('permissions', PermissionController::class);

                Route::apiResource('role-permissions', RolePermissionController::class)
                    ->only(['show', 'update']);

                //        Route::apiResource('teams', \Fintech\Auth\Http\Controllers\TeamController::class);
                //        Route::post('teams/{team}/restore', [\Fintech\Auth\Http\Controllers\TeamController::class, 'restore'])->name('teams.restore');

                Route::apiResource('settings', SettingController::class)
                    ->only(['index', 'store', 'destroy']);

                Route::apiResource('audits', AuditController::class)
                    ->only('index', 'show', 'destroy');

                Route::apiResource('favourites', FavouriteController::class);
                Route::post('favourites/{favourite}/accept', [FavouriteController::class, 'accept'])->name('favourites.accept');
                Route::post('favourites/{favourite}/block', [FavouriteController::class, 'block'])->name('favourites.block');
                //            Route::post('favourites/{favourite}/restore', [FavouriteController::class, 'restore'])->name('favourites.restore');

                Route::apiResource('login-attempts', LoginAttemptController::class)
                    ->only('index', 'show', 'destroy');
                //                Route::post('login-attempts/{login_attempt}/restore', [LoginAttemptController::class, 'restore'])->name('login-attempts.restore');

                Route::post('account-delete', AccountDeleteController::class)->name('account-delete')->middleware('imposter');

                //DO NOT REMOVE THIS LINE//

                Route::prefix('charts')->name('charts.')->group(function () {
                    Route::get('user-role-summary', UserRoleSummaryController::class)
                        ->name('user-role-summary');

                    Route::get('user-status-summary', UserStatusSummaryController::class)
                        ->name('user-status-summary');
                    Route::get('registered-user-summary', RegisteredUserSummaryController::class)
                        ->name('registered-user-summary');
                });
            });

        });
        Route::prefix('dropdown')->name('auth.')->group(function () {
            Route::get('roles', [RoleController::class, 'dropdown'])->name('roles.dropdown');
            //        Route::get('teams', [\Fintech\Auth\Http\Controllers\TeamController::class, 'dropdown'])->name('teams.dropdown');
            Route::get('users', [UserController::class, 'dropdown'])->name('users.dropdown');
            Route::get('user-statuses', [UserController::class, 'statusDropdown'])->name('user-statuses.dropdown');
        });
    });
}
