<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Primary SEO --}}
    <title>@yield('title', 'SiteFueler')</title>
    <meta name="description" content="@yield('description', 'SiteFueler is the WordPress growth platform — premium templates, plugins, code snippets, tutorials, and expert services to help you build, customize, and grow faster.')">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="theme-color" content="#FF5E00">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="SiteFueler">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', 'SiteFueler — WordPress Growth Platform')">
    <meta property="og:description" content="@yield('og_description', 'Premium WordPress templates, plugins, code snippets, tutorials, and expert services.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/og-cover.png'))">
    <meta property="og:locale" content="en_US">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'SiteFueler — WordPress Growth Platform')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Premium WordPress templates, plugins, code snippets, tutorials, and expert services.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('assets/images/og-cover.png'))">

    {{-- Instrument Sans (privacy-friendly Bunny Fonts, no JS) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @stack('styles')

    {{-- Structured data (JSON-LD) — pages opt in by pushing schema blocks. --}}
    @stack('jsonld')
</head>
<body @hasSection('body-class') class="@yield('body-class')" @endif>

    {{-- Specialized layouts (marketing, auth, dashboard, error) fill the body. --}}
    @yield('body')

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
