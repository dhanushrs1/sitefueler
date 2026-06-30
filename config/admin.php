<?php

/*
|--------------------------------------------------------------------------
| SiteFueler Admin
|--------------------------------------------------------------------------
| Sidebar navigation and dashboard stat cards for the admin panel.
| Items reference named routes where they exist; others are placeholders
| (route => null) until their module is built.
|
| Icon keys map to stroked SVGs in resources/views/components/admin/icon.
*/

return [

    'sidebar' => [
        ['title' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'dashboard'],
        ['title' => 'Templates', 'route' => null, 'icon' => 'templates'],
        ['title' => 'Plugins',   'route' => null, 'icon' => 'plugins'],
        ['title' => 'Services',  'route' => null, 'icon' => 'services'],
        ['title' => 'Blog',      'route' => null, 'icon' => 'blog'],
        ['title' => 'Customers', 'route' => null, 'icon' => 'customers'],
        ['title' => 'Orders',    'route' => null, 'icon' => 'orders'],
        ['title' => 'Security',  'route' => 'admin.security', 'icon' => 'shield'],
        ['title' => 'Settings',  'route' => null, 'icon' => 'settings'],
    ],

    // Dashboard stat cards (placeholder values for v0.4.0)
    'dashboard_cards' => [
        ['label' => 'Templates', 'value' => '0',     'icon' => 'templates'],
        ['label' => 'Plugins',   'value' => '0',     'icon' => 'plugins'],
        ['label' => 'Services',  'value' => '0',     'icon' => 'services'],
        ['label' => 'Users',     'value' => '0',     'icon' => 'customers'],
        ['label' => 'Orders',    'value' => '0',     'icon' => 'orders'],
        ['label' => 'Revenue',   'value' => '$0',    'icon' => 'revenue'],
    ],

];
