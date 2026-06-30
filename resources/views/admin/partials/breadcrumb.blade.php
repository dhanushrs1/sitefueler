{{--
    Admin breadcrumb. Pages may override by defining @section('breadcrumb').
    Defaults to: Admin / <page title>.
--}}
@hasSection('breadcrumb')
    <nav class="admin-breadcrumb" aria-label="Breadcrumb">
        @yield('breadcrumb')
    </nav>
@else
    <nav class="admin-breadcrumb" aria-label="Breadcrumb">
        <ol class="admin-breadcrumb__list">
            <li><a href="{{ route('admin.dashboard') }}">Admin</a></li>
            <li class="is-current" aria-current="page">@yield('page_title', 'Dashboard')</li>
        </ol>
    </nav>
@endif
