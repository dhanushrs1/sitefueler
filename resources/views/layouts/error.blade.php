{{--
    Error layout — minimal centered shell for error pages (404, etc.).
    Uses the header/footer for consistency but centers a single message.
--}}
@extends('layouts.app')

@section('body')
    <x-header.header />

    <main id="main" class="main-content error-page">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <x-footer.footer />
@endsection
