@props([
    'title',
    'message' => null,
])

<div {{ $attributes->merge(['class' => 'empty-state']) }}>
    @isset($icon)
        <div class="empty-state__icon" aria-hidden="true">{{ $icon }}</div>
    @endisset

    <h2 class="empty-state__title">{{ $title }}</h2>

    @if ($message)
        <p class="empty-state__message">{{ $message }}</p>
    @endif

    @isset($actions)
        <div class="empty-state__actions">{{ $actions }}</div>
    @endisset
</div>
