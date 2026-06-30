@extends('layouts.marketing')

@section('title', 'Set up two-factor authentication')

@section('content')
<section class="auth-page">
    <div class="auth auth--wide">
        <div class="auth__head">
            <span class="auth__eyebrow">Security</span>
            <h1 class="auth__title">Set up two-factor authentication</h1>
            <p class="auth__subtitle">2FA is required for staff accounts. Finish this once to continue — you can't skip it.</p>
        </div>

        @if ($errors->any())
            <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
        @endif

        <ol class="tfa-flow">
            <li class="tfa-flow__step">
                <header class="tfa-flow__head">
                    <span class="tfa-flow__num">1</span>
                    <h2 class="tfa-flow__title">Scan the QR code</h2>
                </header>
                <div class="tfa-flow__body">
                    <p class="tfa-flow__desc">Open Google or Microsoft Authenticator, Authy, 1Password, or Bitwarden, and point it at this code.</p>

                    <div class="tfa-flow__qr" role="img" aria-label="Two-factor QR code">
                        {!! $qrSvg !!}
                    </div>

                    <details class="tfa-disclosure">
                        <summary class="tfa-disclosure__summary">
                            <span>Can't scan? Enter the key manually</span>
                            <svg class="tfa-disclosure__chev" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </summary>
                        <div class="tfa-disclosure__body">
                            <p class="tfa-disclosure__hint">Add the account by hand using this setup key:</p>
                            <code class="tfa-secret">{{ trim(chunk_split($secret, 4, ' ')) }}</code>
                        </div>
                    </details>
                </div>
            </li>

            <li class="tfa-flow__step">
                <header class="tfa-flow__head">
                    <span class="tfa-flow__num">2</span>
                    <h2 class="tfa-flow__title">Enter the 6-digit code</h2>
                </header>
                <div class="tfa-flow__body">
                    <p class="tfa-flow__desc">Type the current code shown in your app to confirm everything works.</p>

                    <form method="post" action="{{ route('two-factor.setup.confirm') }}" class="tfa-flow__form">
                        @csrf

                        <input
                            class="tfa-otp"
                            id="code"
                            name="code"
                            type="text"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            placeholder="000000"
                            maxlength="6"
                            pattern="\d{6}"
                            required
                            autofocus
                            aria-label="Six-digit verification code"
                        >

                        <x-button variant="primary" type="submit" size="lg" :block="true" class="auth__submit">
                            Verify &amp; continue
                        </x-button>
                    </form>
                </div>
            </li>
        </ol>
    </div>
</section>
@endsection
