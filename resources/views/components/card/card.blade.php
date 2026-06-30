@props([
    'variant' => 'base',   {{-- base | product | service | blog --}}
    'href' => null,        {{-- when set, the whole card is a link (interactive) --}}
    'interactive' => false,
    'disabled' => false,
])

@php
    $isLink = $href && ! $disabled;
    $isInteractive = $interactive || $isLink;

    $classes = collect([
        'card',
        $variant !== 'base' ? 'card--' . $variant : null,
        $isInteractive ? 'card--interactive' : null,
        $disabled ? 'card--disabled' : null,
    ])->filter()->implode(' ');
@endphp

@php $tag = $isLink ? 'a' : 'div'; @endphp

<{{ $tag }}
    @if ($isLink) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    @isset($media)
        <div class="card__media">
            {{ $media }}
            @isset($badges)<div class="card__badges">{{ $badges }}</div>@endisset
        </div>
    @endisset

    <div class="card__body">
        {{ $slot }}
        @isset($footer)<div class="card__footer">{{ $footer }}</div>@endisset
    </div>
</{{ $tag }}>
