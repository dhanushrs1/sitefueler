<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiteFueler')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body>

@include('partials.header')

<main>
    @yield('content')
</main>

@include('partials.footer')

<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
