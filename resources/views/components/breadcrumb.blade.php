@props([
    'items' => [],   {{-- [ ['title' => 'Templates', 'url' => '/templates'], ['title' => 'Detail'] ] --}}
])

<nav {{ $attributes->merge(['class' => 'breadcrumb']) }} aria-label="Breadcrumb">
    <ol class="breadcrumb__list">
        @foreach ($items as $i => $item)
            @php $isLast = $i === array_key_last($items); @endphp
            <li class="breadcrumb__item @if ($isLast) breadcrumb__item--current @endif"
                @if ($isLast) aria-current="page" @endif>
                @if (! $isLast && ! empty($item['url']))
                    <a class="breadcrumb__link" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                    <span class="breadcrumb__sep" aria-hidden="true">/</span>
                @else
                    {{ $item['title'] }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
