@props([
    'name',
    'id' => null,
    'type' => 'text',     {{-- text | email | password | number | search | url | tel --}}
    'label' => null,
    'hint' => null,
    'error' => null,
    'state' => 'default',
    'required' => false,
    'value' => null,
    'placeholder' => null,
    'disabled' => false,
    'readonly' => false,
])

@php
    $id = $id ?? $name;
    $describedBy = $error ? $id . '-error' : ($hint ? $id . '-hint' : null);
    $hasPrefix = isset($prefix);
    $hasSuffix = isset($suffix);
    $wrapClasses = collect([
        'field__control',
        $hasPrefix ? 'field__control--has-prefix' : null,
        $hasSuffix ? 'field__control--has-suffix' : null,
    ])->filter()->implode(' ');
@endphp

<x-form.field :label="$label" :for="$id" :hint="$hint" :error="$error" :state="$state" :required="$required">
    <div class="{{ $wrapClasses }}">
        @if ($hasPrefix)
            <span class="field__affix field__affix--prefix">{{ $prefix }}</span>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            @if (! is_null($value)) value="{{ $value }}" @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            @if ($readonly) readonly @endif
            @if ($error) aria-invalid="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->merge(['class' => 'form-control']) }}
        >

        @if ($hasSuffix)
            <span class="field__affix field__affix--suffix">{{ $suffix }}</span>
        @endif
    </div>
</x-form.field>
