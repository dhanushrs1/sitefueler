@props([
    'variant' => 'primary',   {{-- primary | secondary | ghost | danger --}}
    'size' => 'md',           {{-- sm | md | lg --}}
    'type' => 'button',       {{-- button | submit | reset --}}
    'href' => null,           {{-- when set, renders an <a> --}}
    'block' => false,         {{-- full width --}}
    'iconOnly' => false,      {{-- square icon button (requires aria-label) --}}
    'loading' => false,
    'disabled' => false,
])

@php
    $classes = collect([
        'btn',
        'btn--' . $variant,
        $size !== 'md' ? 'btn--' . $size : null,
        $block ? 'btn--block' : null,
        $iconOnly ? 'btn--icon' : null,
        $loading ? 'btn--loading' : null,
        $disabled ? 'btn--disabled' : null,
    ])->filter()->implode(' ');
@endphp

@if ($href && ! $disabled)
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if ($loading) aria-busy="true" @endif
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if ($disabled) disabled aria-disabled="true" @endif
        @if ($loading) aria-busy="true" @endif
    >
        {{ $slot }}
    </button>
@endif
