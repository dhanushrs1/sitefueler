@props([
    'variant'  => 'primary',   {{-- primary | secondary | ghost | danger --}}
    'size'     => 'md',        {{-- sm | md | lg --}}
    'type'     => 'button',    {{-- button | submit | reset (only when rendering <button>) --}}
    'href'     => null,        {{-- when set, renders an <a> instead of <button> --}}
    'block'    => false,       {{-- full-width --}}
    'iconOnly' => false,       {{-- square icon button — REQUIRES aria-label on the tag --}}
    'loading'  => false,
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

    // Render as a link only when an href is given and the control isn't disabled.
    $asLink = $href && ! $disabled;
@endphp

@if ($asLink)
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if ($loading) aria-busy="true" @endif
        @if ($disabled) aria-disabled="true" @endif
    >
        @isset($iconLeft)<span class="btn__icon" aria-hidden="true">{{ $iconLeft }}</span>@endisset
        {{ $slot }}
        @isset($iconRight)<span class="btn__icon" aria-hidden="true">{{ $iconRight }}</span>@endisset
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if ($disabled) disabled aria-disabled="true" @endif
        @if ($loading) aria-busy="true" @endif
    >
        @isset($iconLeft)<span class="btn__icon" aria-hidden="true">{{ $iconLeft }}</span>@endisset
        {{ $slot }}
        @isset($iconRight)<span class="btn__icon" aria-hidden="true">{{ $iconRight }}</span>@endisset
    </button>
@endif
