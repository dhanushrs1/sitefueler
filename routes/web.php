<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteController;
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

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// OAuth (Google for v1)
Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('oauth.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('oauth.callback');

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
    ->middleware(['auth', 'role:' . $adminRoles])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // Future modules plug in here:
        // Route::resource('templates', TemplateController::class);
        // Route::resource('plugins', PluginController::class);
        // Route::resource('services', ServiceController::class);
    });
