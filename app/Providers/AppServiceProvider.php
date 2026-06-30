<?php

namespace App\Providers;

use App\Support\PasswordRules;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Baseline password policy used by Password::defaults() (customer tier).
        Password::defaults(fn () => PasswordRules::customer());
    }
}
