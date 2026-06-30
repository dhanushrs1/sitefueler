<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SecurityController as AdminSecurityController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\TwoFactorChallengeController;
use App\Http\Controllers\Auth\TwoFactorSetupController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

/*
|--------------------------------------------------------------------------
| Authentication (one identity for everyone)
|--------------------------------------------------------------------------
*/
Route::get('login', [LoginController::class, 'show'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.attempt');

Route::get('register', [RegisterController::class, 'show'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.attempt');

// Forgot password (UI; reset logic wired later)
Route::get('forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'send'])->name('password.email');

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// OAuth (Google for v1)
Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('oauth.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('oauth.callback');

/*
|--------------------------------------------------------------------------
| Two-Factor Authentication
|--------------------------------------------------------------------------
*/
// Challenge — runs BEFORE authentication completes (gated by a pending-login
// session, not the auth middleware).
Route::get('two-factor/challenge', [TwoFactorChallengeController::class, 'show'])->name('two-factor.challenge');
Route::post('two-factor/challenge', [TwoFactorChallengeController::class, 'verify'])->name('two-factor.challenge.verify');

// Mandatory setup wizard — authenticated but not-yet-enrolled users are forced
// here. Kept outside the admin group to avoid an enrollment redirect loop.
Route::middleware('auth')->group(function () {
    Route::get('two-factor/setup', [TwoFactorSetupController::class, 'show'])->name('two-factor.setup');
    Route::post('two-factor/setup', [TwoFactorSetupController::class, 'confirm'])->name('two-factor.setup.confirm');
    Route::get('two-factor/recovery-codes', [TwoFactorSetupController::class, 'recoveryCodes'])->name('two-factor.recovery-codes');
});

/*
|--------------------------------------------------------------------------
| Customer dashboard
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin (configurable prefix, role-protected, one session)
|--------------------------------------------------------------------------
*/
$adminPrefix = config('authentication.admin_prefix', 'admin');
$adminRoles = implode(',', config('authentication.admin_roles', ['admin', 'super-admin']));

Route::prefix($adminPrefix)->name('admin.')
    ->middleware(['auth', 'role:'.$adminRoles, '2fa.enrolled', '2fa.verified', 'admin.timeout'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // Security: 2FA, recovery codes, trusted devices, login history.
        Route::get('security', [AdminSecurityController::class, 'index'])->name('security');
        Route::post('security/recovery-codes', [AdminSecurityController::class, 'regenerateRecoveryCodes'])->name('security.recovery-codes');
        Route::delete('security/devices/{device}', [AdminSecurityController::class, 'revokeDevice'])->name('security.devices.revoke');
        Route::delete('security/devices', [AdminSecurityController::class, 'revokeAllDevices'])->name('security.devices.revoke-all');

        // Future modules plug in here:
        // Route::resource('templates', TemplateController::class);
        // Route::resource('plugins', PluginController::class);
        // Route::resource('services', ServiceController::class);
    });
