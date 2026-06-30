@props([
    'name',
    'id' => null,
    'label' => null,
    'hint' => null,
    'error' => null,
    'state' => 'default',
    'required' => false,
    'value' => null,
    'placeholder' => null,
    'rows' => 4,
    'disabled' => false,
    'readonly' => false,
])

@php
    $id = $id ?? $name;
    $describedBy = $error ? $id . '-error' : ($hint ? $id . '-hint' : null);
@endphp

<x-form.field :label="$label" :for="$id" :hint="$hint" :error="$error" :state="$state" :required="$required">
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required @endif
        @if ($disabled) disabled @endif
        @if ($readonly) readonly @endif
        @if ($error) aria-invalid="true" @endif
        @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
        {{ $attributes->merge(['class' => 'form-control form-control--textarea']) }}
    >{{ $value }}</textarea>
</x-form.field>
