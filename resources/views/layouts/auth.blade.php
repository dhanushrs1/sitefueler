{{--
    Auth layout — placeholder for login/register/forgot-password flows.
    Minimal shell (no full header/footer). Implemented in a later milestone.
--}}
@extends('layouts.app')

@section('body')
    <main id="main" class="main-content">
        @yield('content')
    </main>
@endsection
