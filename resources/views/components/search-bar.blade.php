@props([
    'action' => '/search',
    'name' => 'q',
    'placeholder' => 'Search templates, plugins, services…',
])

{{-- Reusable search bar — built on the Form System (no custom input). --}}
<form {{ $attributes->merge(['class' => 'search-bar']) }} action="{{ $action }}" method="get" role="search">
    <x-form.input :name="$name" type="search" :placeholder="$placeholder" aria-label="Search">
        <x-slot:prefix>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </x-slot:prefix>
    </x-form.input>
</form>
