@php $items = config('admin.sidebar', []); @endphp

<aside class="admin-sidebar" id="admin-sidebar">
    <div class="admin-sidebar__head">
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__logo" aria-label="SiteFueler admin">
            <x-logo />
        </a>
    </div>

    <nav class="admin-sidebar__nav" aria-label="Admin">
        @foreach ($items as $item)
            @php
                $href = $item['route'] ? route($item['route']) : '#';
                $active = $item['route'] && request()->routeIs($item['route']);
            @endphp
            <a
                href="{{ $href }}"
                class="admin-sidebar__link @if ($active) is-active @endif @if (! $item['route']) is-disabled @endif"
                @if ($active) aria-current="page" @endif
                @if (! $item['route']) aria-disabled="true" title="Coming soon" @endif
            >
                <x-admin.icon :name="$item['icon']" class="admin-sidebar__icon" />
                <span>{{ $item['title'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
