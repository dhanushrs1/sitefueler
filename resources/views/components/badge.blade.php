@props([
    'variant' => 'new',   {{-- new | sale | best-seller | featured | out-of-stock --}}
])

@php
    // Default label per the fixed set (badge.md §3). Override via the slot.
    $defaultLabels = [
        'new'          => 'New',
        'sale'         => 'Sale',
        'best-seller'  => 'Best Seller',
        'featured'     => 'Featured',
        'out-of-stock' => 'Out of Stock',
    ];
    $label = trim($slot->toHtml()) !== '' ? $slot : ($defaultLabels[$variant] ?? $variant);
@endphp

<span {{ $attributes->merge(['class' => 'badge badge--' . $variant]) }}>
    @isset($icon)<span class="badge__icon" aria-hidden="true">{{ $icon }}</span>@endisset
    {{ $label }}
</span>
