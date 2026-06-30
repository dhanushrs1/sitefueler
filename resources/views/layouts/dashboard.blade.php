{{--
    Dashboard layout — placeholder for the authenticated app shell
    (sidebar + content). Implemented in a later milestone.
--}}
@extends('layouts.app')

@section('body')
    <main id="main" class="main-content">
        @yield('content')
    </main>
@endsection
