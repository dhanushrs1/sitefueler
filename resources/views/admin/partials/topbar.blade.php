@php $user = auth()->user(); @endphp

<header class="admin-topbar">
    <button type="button" class="admin-topbar__burger" data-admin-nav-open aria-label="Open menu" aria-controls="admin-sidebar" aria-expanded="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>

    <div class="admin-topbar__title">@yield('page_title', 'Dashboard')</div>

    <div class="admin-topbar__actions">
        {{-- Notifications --}}
        <div class="admin-dropdown" data-dropdown>
            <button type="button" class="admin-iconbtn" data-dropdown-toggle aria-haspopup="true" aria-expanded="false" aria-label="Notifications">
                <x-admin.icon name="bell" />
                <span class="admin-iconbtn__dot" aria-hidden="true"></span>
            </button>
            <div class="admin-dropdown__menu admin-dropdown__menu--right">
                <p class="admin-dropdown__header">Notifications</p>
                <div class="admin-dropdown__empty">You're all caught up.</div>
            </div>
        </div>

        {{-- Profile --}}
        <div class="admin-dropdown" data-dropdown>
            <button type="button" class="admin-profile" data-dropdown-toggle aria-haspopup="true" aria-expanded="false">
                <span class="admin-profile__avatar" aria-hidden="true">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
                <span class="admin-profile__name">{{ $user->name ?? 'Admin' }}</span>
                <svg class="admin-profile__chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="admin-dropdown__menu admin-dropdown__menu--right">
                <a class="admin-dropdown__item" href="{{ route('admin.profile') }}">
                    <x-admin.icon name="user" /> <span>Profile</span>
                </a>
                <a class="admin-dropdown__item" href="{{ route('admin.security') }}">
                    <x-admin.icon name="shield" /> <span>Security</span>
                </a>
                <div class="admin-dropdown__divider"></div>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-dropdown__item admin-dropdown__item--danger">
                        <x-admin.icon name="logout" /> <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
