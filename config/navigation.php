<?php

/*
|--------------------------------------------------------------------------
| SiteFueler Navigation
|--------------------------------------------------------------------------
| Central definition of site navigation. The Header and Footer loop over
| these arrays, so adding/removing items never requires editing Blade.
|
| Each item: ['title' => string, 'url' => string, 'children' => array?]
| 'children' is reserved for future dropdowns/mega-menus (no redesign needed).
*/

return [

    // Primary header navigation
    'primary' => [
        ['title' => 'Home',      'url' => '/'],
        ['title' => 'Templates', 'url' => '/templates'],
        ['title' => 'Plugins',   'url' => '/plugins'],
        ['title' => 'Services',  'url' => '/services'],
        ['title' => 'Blog',      'url' => '/blog'],
        ['title' => 'Contact',   'url' => '/contact'],
    ],

    // Footer link columns
    'footer' => [
        'Product' => [
            ['title' => 'Templates', 'url' => '/templates'],
            ['title' => 'Plugins',   'url' => '/plugins'],
            ['title' => 'Services',  'url' => '/services'],
        ],
        'Company' => [
            ['title' => 'Blog',     'url' => '/blog'],
            ['title' => 'Contact',  'url' => '/contact'],
            ['title' => 'About',    'url' => '/about'],
        ],
    ],

    // Legal links (footer bottom bar)
    'legal' => [
        ['title' => 'Privacy', 'url' => '/privacy'],
        ['title' => 'Terms',   'url' => '/terms'],
    ],

];
