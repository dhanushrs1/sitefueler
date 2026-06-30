<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login · SiteFueler</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">
</head>
<body class="admin-auth">
    <main class="admin-auth__card">
        <a href="/" class="admin-auth__logo" aria-label="SiteFueler home">
            <x-logo />
        </a>

        <h1 class="admin-auth__title">Admin sign in</h1>
        <p class="admin-auth__subtitle">Sign in to manage SiteFueler.</p>

        @if ($errors->any())
            <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
        @endif

        <form method="post" action="{{ route('admin.login.attempt') }}">
            @csrf

            <x-form.input
                name="email"
                type="email"
                label="Email"
                placeholder="you@sitefueler.com"
                :value="old('email')"
                required
            />

            <x-form.input
                name="password"
                type="password"
                label="Password"
                placeholder="••••••••"
                required
            />

            <label class="admin-auth__remember">
                <x-form.checkbox name="remember" label="Remember me" />
            </label>

            <x-button variant="primary" type="submit" :block="true" class="mt-8">Sign in</x-button>
        </form>
    </main>
</body>
</html>
