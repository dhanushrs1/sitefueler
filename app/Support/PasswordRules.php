<?php

namespace App\Support;

use Illuminate\Validation\Rules\Password;

/**
 * Role-aware password policy. Admins get a strict policy (>= 12 chars, mixed
 * case, number, symbol, and a compromised-password check); customers a relaxed
 * one. Driven by config/authentication.php → 'passwords'.
 */
class PasswordRules
{
    public static function for(string $tier): Password
    {
        $config = config("authentication.passwords.{$tier}", config('authentication.passwords.customer'));

        $rule = Password::min($config['min'] ?? 8);

        if (! empty($config['mixed_case'])) {
            $rule->mixedCase();
        }
        if (! empty($config['numbers'])) {
            $rule->numbers();
        }
        if (! empty($config['symbols'])) {
            $rule->symbols();
        }
        if (! empty($config['uncompromised'])) {
            $rule->uncompromised();
        }

        return $rule;
    }

    public static function admin(): Password
    {
        return self::for('admin');
    }

    public static function customer(): Password
    {
        return self::for('customer');
    }
}
