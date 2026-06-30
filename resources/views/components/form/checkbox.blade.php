@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'required' => false,
])

@php $id = $id ?? $name; @endphp

<label class="choice choice--checkbox" @if ($id) for="{{ $id }}" @endif>
    <input
        type="checkbox"
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
