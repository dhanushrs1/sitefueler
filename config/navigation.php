<?php

/*
|--------------------------------------------------------------------------
| SiteFueler Navigation
|--------------------------------------------------------------------------
| Central definition of site navigation. Header, off-canvas drawer, and
| Footer loop over these arrays — no hardcoded items in Blade.
|
| Item: ['title' => string, 'url' => string, 'children' => array?]
| 'children' renders a dropdown (desktop) / accordion (drawer).
*/

return [

    // Primary header navigation (desktop) — some items have dropdowns
    'primary' => [
        ['title' => 'Home', 'url' => '/'],
        ['title' => 'Templates', 'url' => '/templates', 'children' => [
            ['title' => 'WordPress Themes', 'url' => '/templates/wordpress'],
            ['title' => 'HTML Templates',   'url' => '/templates/html'],
            ['title' => 'Email Templates',  'url' => '/templates/email'],
        ]],
        ['title' => 'Plugins', 'url' => '/plugins', 'children' => [
            ['title' => 'SEO',          'url' => '/plugins/seo'],
            ['title' => 'Performance',  'url' => '/plugins/performance'],
            ['title' => 'Security',     'url' => '/plugins/security'],
            ['title' => 'eCommerce',    'url' => '/plugins/ecommerce'],
        ]],
        ['title' => 'Services', 'url' => '/services', 'children' => [
            ['title' => 'Custom Development',   'url' => '/services/development'],
            ['title' => 'Site Migration',       'url' => '/services/migration'],
            ['title' => 'Maintenance & Support','url' => '/services/support'],
        ]],
        ['title' => 'Blog', 'url' => '/blog'],
        ['title' => 'Contact', 'url' => '/contact'],
    ],

    // Off-canvas drawer menu (mobile) — a fuller set than the header
    'drawer' => [
        ['title' => 'Home', 'url' => '/'],
        ['title' => 'Templates', 'url' => '/templates', 'children' => [
            ['title' => 'WordPress Themes', 'url' => '/templates/wordpress'],
            ['title' => 'HTML Templates',   'url' => '/templates/html'],
            ['title' => 'Email Templates',  'url' => '/templates/email'],
        ]],
        ['title' => 'Plugins', 'url' => '/plugins', 'children' => [
            ['title' => 'SEO',          'url' => '/plugins/seo'],
            ['title' => 'Performance',  'url' => '/plugins/performance'],
            ['title' => 'Security',     'url' => '/plugins/security'],
            ['title' => 'eCommerce',    'url' => '/plugins/ecommerce'],
        ]],
        ['title' => 'Services', 'url' => '/services', 'children' => [
            ['title' => 'Custom Development',   'url' => '/services/development'],
            ['title' => 'Site Migration',       'url' => '/services/migration'],
            ['title' => 'Maintenance & Support','url' => '/services/support'],
        ]],
        ['title' => 'Pricing', 'url' => '/pricing'],
        ['title' => 'Blog', 'url' => '/blog'],
        ['title' => 'Documentation', 'url' => '/docs'],
        ['title' => 'About', 'url' => '/about'],
        ['title' => 'Contact', 'url' => '/contact'],
    ],

    // Footer link columns
    'footer' => [
        'Best Selling' => [
            ['title' => 'Templates', 'url' => '/templates'],
            ['title' => 'Plugins',   'url' => '/plugins'],
            ['title' => 'Services',  'url' => '/services'],
            ['title' => 'Themes',    'url' => '/templates'],
        ],
        'Useful Links' => [
            ['title' => 'Home',          'url' => '/'],
            ['title' => 'About',         'url' => '/about'],
            ['title' => 'Contact',       'url' => '/contact'],
            ['title' => 'Terms & Conditions', 'url' => '/terms'],
        ],
    ],

    // Legal links (footer bottom bar)
    'legal' => [
        ['title' => 'Privacy', 'url' => '/privacy'],
        ['title' => 'Terms',   'url' => '/terms'],
    ],

    // Social follow links (icon keys: x, github, linkedin, youtube)
    'social' => [
        ['title' => 'X (Twitter)', 'url' => 'https://x.com/sitefueler',        'icon' => 'x'],
        ['title' => 'GitHub',      'url' => 'https://github.com/sitefueler',   'icon' => 'github'],
        ['title' => 'LinkedIn',    'url' => 'https://linkedin.com/company/sitefueler', 'icon' => 'linkedin'],
        ['title' => 'YouTube',     'url' => 'https://youtube.com/@sitefueler', 'icon' => 'youtube'],
    ],

];
