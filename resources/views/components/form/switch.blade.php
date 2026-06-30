@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
])

@php $id = $id ?? $name; @endphp

<label class="switch" for="{{ $id }}">
    <input
        type="checkbox"
        role="switch"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked($checked)
        @if ($disabled) disabled @endif
        {{ $attributes }}
    >
    @if ($label)<span class="choice__label">{{ $label }}</span>@endif
    {{ $slot }}
</label>
