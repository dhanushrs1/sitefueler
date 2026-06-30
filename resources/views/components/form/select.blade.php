@props([
    'name',
    'id' => null,
    'label' => null,
    'hint' => null,
    'error' => null,
    'state' => 'default',
    'required' => false,
    'options' => [],      {{-- [value => label] or list of labels --}}
    'selected' => null,
    'placeholder' => null,
    'disabled' => false,
])

@php
    $id = $id ?? $name;
    $describedBy = $error ? $id . '-error' : ($hint ? $id . '-hint' : null);
@endphp

<x-form.field :label="$label" :for="$id" :hint="$hint" :error="$error" :state="$state" :required="$required">
    <div class="field__control field__control--has-suffix">
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            @if ($error) aria-invalid="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->merge(['class' => 'form-control form-control--select']) }}
        >
            @if ($placeholder)
                <option value="" disabled @selected(is_null($selected))>{{ $placeholder }}</option>
            @endif

            @if (count($options))
                {{-- Support both [value => label] maps and plain lists --}}
                @foreach ($options as $optValue => $optLabel)
                    <option value="{{ $optValue }}" @selected((string) $selected === (string) $optValue)>{{ $optLabel }}</option>
                @endforeach
            @else
                {{ $slot }}
            @endif
        </select>

        {{-- Chevron (Lucide chevron-down). Decorative; native arrow is hidden. --}}
        <span class="field__affix field__affix--suffix" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </span>
    </div>
</x-form.field>
