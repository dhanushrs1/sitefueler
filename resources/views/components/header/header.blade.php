@php $items = config('navigation.primary', []); @endphp

<header class="site-header">
    <div class="container site-header__inner">
        {{-- Logo --}}
        <a href="/" class="site-header__logo" aria-label="SiteFueler home">
            <x-logo />
        </a>

        {{-- Primary navigation (desktop, left-aligned next to the logo) --}}
        <x-header.navigation :items="$items" />

        {{-- Right-side actions --}}
        <div class="site-header__actions">
            {{-- Cart (stroked icon, placeholder for future cart) --}}
            <a href="/cart" class="site-header__icon-btn" aria-label="Cart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            </a>

            <span class="site-header__cta">
                <x-button variant="ghost" size="sm" href="/login">Login</x-button>
                <x-button variant="primary" size="sm" href="/get-started">Get Started</x-button>
            </span>

            {{-- Hamburger (mobile) --}}
            <button
                type="button"
                class="site-header__burger"
                data-nav-open
                aria-label="Open menu"
                aria-expanded="false"
                aria-controls="site-mobile-nav"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>
    </div>

    {{-- Off-canvas mobile drawer (slides in from the right) --}}
    <div class="nav-drawer" id="site-mobile-nav">
        <div class="nav-drawer__backdrop" data-nav-close></div>

        <aside class="nav-drawer__panel" role="dialog" aria-modal="true" aria-label="Menu">
            <div class="nav-drawer__head">
                <a href="/" class="site-header__logo" aria-label="SiteFueler home"><x-logo /></a>
                <button type="button" class="nav-drawer__close" data-nav-close aria-label="Close menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <x-header.navigation :items="$items" class="nav-drawer__nav site-nav" />

            <div class="nav-drawer__cta">
                <x-button variant="ghost" href="/login" :block="true">Login</x-button>
                <x-button variant="primary" href="/get-started" :block="true">Get Started</x-button>
            </div>
        </aside>
    </div>
</header>
