@props([
    'items' => [],
])

<nav class="drawer-menu" aria-label="Mobile">
    @foreach ($items as $item)
        @if (! empty($item['children']))
            <details class="drawer-menu__group">
                <summary class="drawer-menu__summary">
                    <span>{{ $item['title'] }}</span>
                    <svg class="drawer-menu__chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                </summary>
                <ul class="drawer-menu__sub">
                    <li><a class="drawer-menu__sublink" href="{{ $item['url'] }}">All {{ $item['title'] }}</a></li>
                    @foreach ($item['children'] as $child)
                        <li><a class="drawer-menu__sublink" href="{{ $child['url'] }}">{{ $child['title'] }}</a></li>
                    @endforeach
                </ul>
            </details>
        @else
            <a class="drawer-menu__link" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
        @endif
    @endforeach
</nav>
