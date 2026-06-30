@props([
    'layout' => 'row',   {{-- row | row-2 | inline --}}
])

@php
    $classes = match ($layout) {
        'row-2'  => 'form-row form-row--2',
        'inline' => 'form-inline',
        default  => 'form-row',
    };
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
