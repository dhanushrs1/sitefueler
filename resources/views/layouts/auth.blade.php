{{--
    Auth layout — header + centered content + slim footer.
    Designed to fit on one screen (no scroll) and stay on-brand.
--}}
@extends('layouts.app')

@section('body')
    <div class="auth-shell">
        <x-header.header />

        <main class="auth-shell__main">
            @yield('content')
        </main>

        <footer class="auth-shell__footer">
            <span>&copy; {{ date('Y') }} SiteFueler</span>
            <nav class="auth-shell__legal" aria-label="Legal">
                <a href="/privacy">Privacy</a>
                <a href="/terms">Terms</a>
            </nav>
        </footer>
    </div>
@endsection
