@extends('admin.layouts.app')

@section('title', 'Security')
@section('page_title', 'Security')

@section('content')
    @if (session('status'))
        <x-alert variant="success" class="mb-16">{{ session('status') }}</x-alert>
    @endif

    @if ($errors->any())
        <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
    @endif

    {{-- Two-factor status --}}
    <div class="admin-panel mb-24">
        <div class="sec-head">
            <h2 class="sec-head__title">Two-factor authentication</h2>
            @if ($user->hasConfirmedTwoFactor())
                <span class="sec-pill sec-pill--on">Enabled</span>
            @else
                <span class="sec-pill sec-pill--off">Not set up</span>
            @endif
        </div>

        @if ($user->hasConfirmedTwoFactor())
            <p class="sec-text">
                Confirmed {{ $user->two_factor_confirmed_at->diffForHumans() }}.
                You have <strong>{{ $recoveryCount }}</strong> unused recovery code{{ $recoveryCount === 1 ? '' : 's' }}.
            </p>

            @if ($newRecoveryCodes)
                <x-alert variant="warning" class="mb-16">New recovery codes — shown only once. Save them now.</x-alert>
                <ul class="tfa-codes mb-16">
                    @foreach ($newRecoveryCodes as $code)
                        <li class="tfa-codes__item">{{ $code }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="post" action="{{ route('admin.security.recovery-codes') }}">
                @csrf
                <x-button variant="secondary" type="submit">Regenerate recovery codes</x-button>
            </form>
        @else
            <p class="sec-text">Two-factor authentication is required for your role but isn't set up yet.</p>
            <x-button variant="primary" :href="route('two-factor.setup')">Set up 2FA</x-button>
        @endif
    </div>

    {{-- Trusted devices --}}
    <div class="admin-panel mb-24">
        <div class="sec-head">
            <h2 class="sec-head__title">Trusted devices</h2>
            @if ($devices->isNotEmpty())
                <form method="post" action="{{ route('admin.security.devices.revoke-all') }}">
                    @csrf
                    @method('delete')
                    <x-button variant="ghost" size="sm" type="submit">Revoke all</x-button>
                </form>
            @endif
        </div>

        @if ($devices->isEmpty())
            <p class="sec-text">No trusted devices. You'll be asked for a code on every sign-in.</p>
        @else
            <table class="sec-table">
                <thead>
                    <tr>
                        <th>Device</th>
                        <th>IP address</th>
                        <th>Last used</th>
                        <th>Expires</th>
                        <th><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr>
                            <td>{{ $device->name ?? 'Unknown device' }}</td>
                            <td>{{ $device->ip_address ?? '—' }}</td>
                            <td>{{ optional($device->last_used_at)->diffForHumans() ?? '—' }}</td>
                            <td>{{ $device->expires_at->toFormattedDateString() }}</td>
                            <td class="sec-table__actions">
                                <form method="post" action="{{ route('admin.security.devices.revoke', $device->id) }}">
                                    @csrf
                                    @method('delete')
                                    <x-button variant="ghost" size="sm" type="submit">Revoke</x-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Recent logins --}}
    <div class="admin-panel">
        <div class="sec-head">
            <h2 class="sec-head__title">Recent sign-in activity</h2>
        </div>

        @if ($logins->isEmpty())
            <p class="sec-text">No sign-in activity recorded yet.</p>
        @else
            <table class="sec-table">
                <thead>
                    <tr>
                        <th>When</th>
                        <th>IP address</th>
                        <th>Browser</th>
                        <th>Device</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logins as $login)
                        <tr>
                            <td>{{ $login->created_at->diffForHumans() }}</td>
                            <td>{{ $login->ip_address ?? '—' }}</td>
                            <td>{{ $login->browser ?? '—' }}</td>
                            <td>{{ $login->device ?? '—' }}</td>
                            <td>
                                @if ($login->successful)
                                    <span class="sec-pill sec-pill--on">Success</span>
                                @else
                                    <span class="sec-pill sec-pill--off">Failed</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
