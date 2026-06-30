@extends('layouts.error')

@section('title', 'Page not found')

@section('content')
    <x-empty-state
        title="Page not found"
        message="The page you're looking for doesn't exist or may have moved."
    >
        <x-slot:icon>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </x-slot:icon>
        <x-slot:actions>
            <x-button variant="primary" href="/">Back to home</x-button>
        </x-slot:actions>
    </x-empty-state>
@endsection
