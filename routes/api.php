<?php

use Fintech\Auth\Http\Controllers\AuditController;
use Fintech\Auth\Http\Controllers\AuthenticatedController;
use Fintech\Auth\Http\Controllers\FavouriteController;
use Fintech\Auth\Http\Controllers\OneTimePinController;
use Fintech\Auth\Http\Controllers\PasswordResetController;
use Fintech\Auth\Http\Controllers\PermissionController;
use Fintech\Auth\Http\Controllers\ProofOfAddressDropDownController;
use Fintech\Auth\Http\Controllers\RegisterController;
use Fintech\Auth\Http\Controllers\RoleController;
use Fintech\Auth\Http\Controllers\RolePermissionController;
use Fintech\Auth\Http\Controllers\SettingController;
use Fintech\Auth\Http\Controllers\UserController;
use Fintech\MetaData\Http\Controllers\IdDocTypeController;
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
        Route::post('/register', RegisterController::class)
            ->middleware('guest')
            ->name('register');

        Route::post('/login', [AuthenticatedController::class, 'login'])
            ->middleware('guest')
            ->name('login');

        Route::post('/logout', [AuthenticatedController::class, 'logout'])
            ->middleware(config('fintech.auth.middleware'))
            ->name('logout');

        if (config('fintech.auth.self_password_reset')) {

            Route::post('/forgot-password', [PasswordResetController::class, 'store'])
                ->middleware('guest')
                ->name('forgot-password');

            Route::post('/reset-password', [PasswordResetController::class, 'update'])
                ->middleware('guest')
                ->name('reset-password');
        }

        Route::post('/request-otp', [OneTimePinController::class, 'request'])
            ->name('request-otp');

        Route::post('/verify-otp', [OneTimePinController::class, 'verify'])
            ->name('verify-otp');

        Route::middleware(config('fintech.auth.middleware'))->group(function () {
            Route::apiResource('users', UserController::class);
            Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
            Route::post('users/change-status', [UserController::class, 'changeStatus'])->name('users.change-status');
            Route::post('users/{user}/reset/{field}', [UserController::class, 'reset'])
                ->name('users.reset-password-pin')->whereIn('field', ['pin', 'password', 'both']);

            Route::apiResource('roles', RoleController::class);
            Route::post('roles/{role}/restore', [RoleController::class, 'restore'])->name('roles.restore');

            Route::apiResource('permissions', PermissionController::class);
            Route::post('permissions/{permission}/restore', [PermissionController::class, 'restore'])->name('permissions.restore');

            //        Route::apiResource('teams', \Fintech\Auth\Http\Controllers\TeamController::class);
            //        Route::post('teams/{team}/restore', [\Fintech\Auth\Http\Controllers\TeamController::class, 'restore'])->name('teams.restore');

            Route::apiResource('settings', SettingController::class)->only(['index', 'store', 'destroy']);

            Route::apiResource('audits', AuditController::class)->only('index', 'show', 'destroy');

            Route::apiResource('id-doc-types', IdDocTypeController::class);
            Route::post('id-doc-types/{id_doc_type}/restore', [IdDocTypeController::class, 'restore'])->name('id-doc-types.restore');

            Route::apiResource('role-permissions', RolePermissionController::class)->only(['show', 'update']);

            Route::apiResource('favourites', FavouriteController::class);
            Route::post('favourites/{favourite}/restore', [FavouriteController::class, 'restore'])->name('favourites.restore');

            //DO NOT REMOVE THIS LINE//
        });

        Route::post('id-doc-verification', [IdDocTypeController::class, 'verification'])->name('id-doc-verification');
    });
    Route::prefix('dropdown')->name('auth.')->group(function () {
        Route::get('id-doc-types', [IdDocTypeController::class, 'dropdown'])->name('id-doc-types.dropdown');
        Route::get('roles', [RoleController::class, 'dropdown'])->name('roles.dropdown');
        //        Route::get('teams', [\Fintech\Auth\Http\Controllers\TeamController::class, 'dropdown'])->name('teams.dropdown');
        Route::get('users', [UserController::class, 'dropdown'])->name('users.dropdown');
        Route::get('user-statuses', [UserController::class, 'statusDropdown'])->name('user-statuses.dropdown');
        Route::get('proof-of-addresses', ProofOfAddressDropDownController::class)->name('user-proof-of-address.dropdown');
    });
}
