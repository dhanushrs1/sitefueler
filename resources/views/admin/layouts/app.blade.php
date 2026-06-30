<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') · SiteFueler</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin">

    @include('admin.partials.sidebar')

    <div class="admin__main">
        @include('admin.partials.topbar')

        <main class="admin__content">
            @include('admin.partials.breadcrumb')

            @yield('content')
        </main>
    </div>

    <div class="admin__backdrop" data-admin-nav-close></div>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
