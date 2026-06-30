@props([
    'logo' => 'SiteFueler',
])

@php $items = config('navigation.primary', []); @endphp

<header class="site-header">
    <div class="container site-header__inner">
        {{-- Mobile hamburger --}}
        <button
            type="button"
            class="site-header__burger"
            data-nav-toggle
            aria-label="Menu"
            aria-expanded="false"
            aria-controls="site-mobile-nav"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>

        {{-- Logo --}}
        <a href="/" class="site-header__logo">{{ $logo }}</a>

        {{-- Primary navigation (desktop, centered) --}}
        <x-header.navigation :items="$items" />

        {{-- Right-side actions --}}
        <div class="site-header__actions">
            <x-button variant="ghost" :iconOnly="true" aria-label="Search" data-search-toggle>
                <x-slot:iconLeft>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </x-slot:iconLeft>
            </x-button>

            <span class="site-header__cta">
                <x-button variant="ghost" href="/login">Login</x-button>
                <x-button variant="primary" href="/get-started">Get Started</x-button>
            </span>
        </div>
    </div>

    {{-- Mobile dropdown panel --}}
    <div class="container">
        <div class="site-header__mobile" id="site-mobile-nav">
            <x-search-bar />
            <x-header.navigation :items="$items" />
            <div class="site-header__mobile-cta">
                <x-button variant="ghost" href="/login" :block="true">Login</x-button>
                <x-button variant="primary" href="/get-started" :block="true">Get Started</x-button>
            </div>
        </div>
    </div>
</header>
