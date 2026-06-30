@props([
    'items' => [],
])

@php
    $isActive = function ($url) {
        $path = ltrim($url, '/');
        return $path === '' ? request()->is('/') : request()->is($path . '*');
    };
@endphp

<nav class="site-nav" aria-label="Primary">
    <ul class="site-nav__list">
        @foreach ($items as $item)
            @php $hasChildren = ! empty($item['children']); @endphp

            @if ($hasChildren)
                <li class="site-nav__item site-nav__item--has-dropdown">
                    <a
                        href="{{ $item['url'] }}"
                        class="site-nav__link @if ($isActive($item['url'])) is-active @endif"
                        aria-haspopup="true"
                    >
                        {{ $item['title'] }}
                        <svg class="site-nav__chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </a>

                    <div class="site-nav__dropdown">
                        <ul class="site-nav__dropdown-list">
                            @foreach ($item['children'] as $child)
                                <li>
                                    <a class="site-nav__dropdown-link" href="{{ $child['url'] }}">{{ $child['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @else
                <li class="site-nav__item">
                    <a
                        href="{{ $item['url'] }}"
                        class="site-nav__link @if ($isActive($item['url'])) is-active @endif"
                        @if ($isActive($item['url'])) aria-current="page" @endif
                    >{{ $item['title'] }}</a>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
