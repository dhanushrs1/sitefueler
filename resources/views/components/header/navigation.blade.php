@props([
    'items' => [],
    'class' => 'site-nav',
])

<nav class="{{ $class }}" aria-label="Primary">
    @foreach ($items as $item)
        @php
            $path = ltrim($item['url'], '/');
            $active = $path === '' ? request()->is('/') : request()->is($path . '*');
        @endphp
        <a
            href="{{ $item['url'] }}"
            class="site-nav__link @if ($active) is-active @endif"
            @if ($active) aria-current="page" @endif
        >{{ $item['title'] }}</a>
    @endforeach
</nav>
