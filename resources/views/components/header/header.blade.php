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

            @auth
                @php $u = auth()->user(); @endphp
                <div class="site-header__user site-nav__item--has-dropdown">
                    <button type="button" class="site-header__user-btn" aria-haspopup="true">
                        <span class="site-header__avatar" aria-hidden="true">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                        <svg class="site-nav__chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="site-nav__dropdown site-nav__dropdown--right">
                        <ul class="site-nav__dropdown-list">
                            @if ($u->isAdmin())
                                <li><a class="site-nav__dropdown-link" href="{{ route('admin.dashboard') }}">Go to Admin</a></li>
                            @else
                                <li><a class="site-nav__dropdown-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                            @endif
                            <li><a class="site-nav__dropdown-link" href="{{ route('dashboard') }}">Profile</a></li>
                            <li>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="site-nav__dropdown-link" style="width:100%;text-align:left;">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <span class="site-header__cta">
                    <x-button variant="ghost" size="sm" href="{{ route('login') }}">Login</x-button>
                    <x-button variant="primary" size="sm" href="{{ route('register') }}">Get Started</x-button>
                </span>
            @endauth

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

            <div class="nav-drawer__body">
                <x-header.drawer-menu :items="config('navigation.drawer', [])" />
            </div>

            <div class="nav-drawer__footer">
                <div class="nav-drawer__cta">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <x-button variant="primary" href="{{ route('admin.dashboard') }}" :block="true">Go to Admin</x-button>
                        @else
                            <x-button variant="primary" href="{{ route('dashboard') }}" :block="true">Dashboard</x-button>
                        @endif
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <x-button variant="ghost" type="submit" :block="true">Logout</x-button>
                        </form>
                    @else
                        <x-button variant="ghost" href="{{ route('login') }}" :block="true">Login</x-button>
                        <x-button variant="primary" href="{{ route('register') }}" :block="true">Get Started</x-button>
                    @endauth
                </div>

                <div class="nav-drawer__social">
                    <span class="nav-drawer__social-label">Follow us</span>
                    <x-social-links :links="config('navigation.social', [])" />
                </div>
            </div>
        </aside>
    </div>
</header>
