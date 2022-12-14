<?php

use Illuminate\Support\Facades\Route;
use Shopfolio\Http\Controllers\Auth\ForgotPasswordController;
use Shopfolio\Http\Controllers\Auth\LoginController;
use Shopfolio\Http\Controllers\Auth\ResetPasswordController;
use Shopfolio\Http\Controllers\Auth\TwoFactorAuthenticatedController;

/*
|--------------------------------------------------------------------------
| Auth Web Routes
|--------------------------------------------------------------------------
|
| Base authentication route
|
*/

Route::redirect('/', shopfolio_prefix() . '/login', 301);

// Authentication...
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login-view');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Password Reset...
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// Two Factor Authentication...
if (config('shopfolio.auth.2fa_enabled')) {
    Route::get('/two-factor-login', [TwoFactorAuthenticatedController::class, 'create'])
        ->name('two-factor.login');

    Route::post('/two-factor-login', [TwoFactorAuthenticatedController::class, 'store'])
        ->name('two-factor.post-login');
}
