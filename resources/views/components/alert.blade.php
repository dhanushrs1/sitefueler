@props([
    'variant' => 'info',   {{-- success | warning | danger | info --}}
    'title' => null,
    'dismissible' => false,
])

@php
    // Assertive for high-severity, polite otherwise (alert.md §7).
    $role = in_array($variant, ['danger', 'warning']) ? 'alert' : 'status';

    // Default Lucide-style icon per variant.
    $icons = [
        'success' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
        'warning' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
        'danger'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
        'info'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
    ];
@endphp

<div role="{{ $role }}" {{ $attributes->merge(['class' => 'alert alert--' . $variant]) }}>
    <span class="alert__icon" aria-hidden="true">
        {!! $icon ?? ($icons[$variant] ?? $icons['info']) !!}
    </span>

    <div class="alert__content">
        @if ($title)<p class="alert__title">{{ $title }}</p>@endif
        <div class="alert__message">{{ $slot }}</div>
        @isset($actions)<div class="alert__actions">{{ $actions }}</div>@endisset
    </div>

    @if ($dismissible)
        <button type="button" class="alert__dismiss" data-dismiss="alert" aria-label="Dismiss">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    @endif
</div>
