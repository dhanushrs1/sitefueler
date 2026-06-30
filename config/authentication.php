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

];
