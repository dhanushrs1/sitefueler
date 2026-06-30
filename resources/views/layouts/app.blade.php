<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiteFueler')</title>

    {{-- Instrument Sans (privacy-friendly Bunny Fonts, no JS) --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @stack('styles')
</head>
<body @hasSection('body-class') class="@yield('body-class')" @endif>

    {{-- Specialized layouts (marketing, auth, dashboard, error) fill the body. --}}
    @yield('body')

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
