{{--
    Auth layout — placeholder for any future minimal auth shell.
    The login/register/forgot pages currently use the marketing layout
    (full header + footer).
--}}
@extends('layouts.app')

@section('body')
    <main id="main" class="main-content">
        @yield('content')
    </main>
@endsection
