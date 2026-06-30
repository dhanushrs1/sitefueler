{{--
    Marketing layout — the standard application shell:
    Header → Main content → Footer.
    Pages: @extends('layouts.marketing') and define @section('content').
--}}
@extends('layouts.app')

@section('body')
    <x-header.header />

    <main id="main" class="main-content">
        @yield('content')
    </main>

    <x-footer.footer />
@endsection
