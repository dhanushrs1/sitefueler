<?php

/*
|--------------------------------------------------------------------------
| SiteFueler Identity / Authentication
|--------------------------------------------------------------------------
| One identity system for everyone (frontend, customer, admin). Roles decide
| access — there is one session, not separate admin/customer sessions.
*/

return [

    // Admin URL prefix (configurable; never hardcode in views/routes).
    'admin_prefix' => env('ADMIN_PREFIX', 'admin'),

    // Default role assigned to public self-registrations.
    'default_role' => 'customer',

    // Roles considered "admin" for admin-area authorization.
    'admin_roles' => ['admin', 'super-admin'],

    // OAuth providers (Google enabled for v1; others future).
    'providers' => [
        'google' => [
            'enabled' => env('GOOGLE_CLIENT_ID') !== null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Two-Factor Authentication (TOTP)
    |--------------------------------------------------------------------------
    | Standard TOTP (RFC 6238) — works with any authenticator app (Google /
    | Microsoft Authenticator, Authy, 1Password, Bitwarden, ...). Mandatory for
    | the roles listed below: such users must complete a setup wizard before
    | they can reach the admin panel, and pass a code on every new session.
    */
    'two_factor' => [
        // Roles for which 2FA is mandatory (defaults to the admin roles).
        'required_roles' => ['admin', 'super-admin', 'editor', 'support'],

        // Issuer label shown in the authenticator app.
        'issuer' => env('TWO_FACTOR_ISSUER', env('APP_NAME', 'SiteFueler')),

        // TOTP window tolerance (number of 30s steps before/after to accept).
        'window' => 1,

        // How many one-time recovery codes to generate.
        'recovery_code_count' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Trusted Devices
    |--------------------------------------------------------------------------
    | When a user opts to "remember this device", a signed, expiring token is
    | stored in a cookie and hashed in the database. Trusted devices skip the
    | 2FA challenge until the token expires.
    */
    'trusted_devices' => [
        'cookie' => 'sf_trusted_device',
        'lifetime_days' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Login Throttling
    |--------------------------------------------------------------------------
    | Failed-attempt limits keyed by email + IP. Admin roles get a stricter
    | policy than customers.
    */
    'throttle' => [
        'customer' => ['max_attempts' => 5, 'decay_minutes' => 15],
        'admin' => ['max_attempts' => 5, 'decay_minutes' => 30],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Policy
    |--------------------------------------------------------------------------
    | Customers get a relaxed policy; admins a strict one (>= 12 chars, mixed
    | case, number, symbol, and a check against known compromised passwords).
    */
    'passwords' => [
        'customer' => ['min' => 8],
        'admin' => ['min' => 12, 'mixed_case' => true, 'numbers' => true, 'symbols' => true, 'uncompromised' => true],
    ],

    // Shorter idle session lifetime (minutes) for admin roles (enforced per request).
    'admin_session_lifetime' => (int) env('ADMIN_SESSION_LIFETIME', 30),

];
