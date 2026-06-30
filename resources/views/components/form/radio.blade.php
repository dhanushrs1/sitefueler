@props([
    'name',
    'id' => null,
    'label' => null,
    'value',
    'checked' => false,
    'disabled' => false,
    'required' => false,
])

@php $id = $id ?? ($name . '-' . $value); @endphp

<label class="choice choice--radio" for="{{ $id }}">
    <input
        type="radio"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked($checked)
        @if ($required) required @endif
        @if ($disabled) disabled @endif
        {{ $attributes }}
    >
    @if ($label)<span class="choice__label">{{ $label }}</span>@endif
    {{ $slot }}
</label>
