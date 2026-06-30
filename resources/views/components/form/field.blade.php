@props([
    'label' => null,
    'for' => null,        {{-- id of the control this label points to --}}
    'hint' => null,
    'error' => null,
    'state' => 'default', {{-- default | success | warning | error --}}
    'required' => false,
])

@php
    // An error always forces the error state.
    $resolvedState = $error ? 'error' : $state;
@endphp

<div {{ $attributes->merge(['class' => 'field field--' . $resolvedState]) }}>
    @if ($label)
        <label class="field__label" @if ($for) for="{{ $for }}" @endif>
            {{ $label }}@if ($required)<span class="field__required" aria-hidden="true">*</span>@endif
        </label>
    @endif

    {{ $slot }}

    @if ($error)
        <p class="field__error" @if ($for) id="{{ $for }}-error" @endif>{{ $error }}</p>
    @elseif ($hint)
        <p class="field__hint" @if ($for) id="{{ $for }}-hint" @endif>{{ $hint }}</p>
    @endif
</div>
