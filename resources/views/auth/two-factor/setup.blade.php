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

        <ol class="tfa-steps">
            <li class="tfa-step">
                <h2 class="tfa-step__title">1. Scan the QR code</h2>
                <p class="tfa-step__text">Open your authenticator app (Google or Microsoft Authenticator, Authy, 1Password, Bitwarden, …) and scan this code.</p>
                <div class="tfa-qr" role="img" aria-label="Two-factor QR code">
                    {!! $qrSvg !!}
                </div>
            </li>

            <li class="tfa-step">
                <h2 class="tfa-step__title">2. Or enter the key manually</h2>
                <p class="tfa-step__text">If you can't scan, add an account by hand using this setup key:</p>
                <p class="tfa-secret"><code>{{ trim(chunk_split($secret, 4, ' ')) }}</code></p>
            </li>

            <li class="tfa-step">
                <h2 class="tfa-step__title">3. Enter the 6-digit code</h2>
                <p class="tfa-step__text">Type the current code shown in your app to confirm everything works.</p>

                <form method="post" action="{{ route('two-factor.setup.confirm') }}">
                    @csrf
                    <div class="ff">
                        <input class="ff__input" id="code" name="code" type="text" inputmode="numeric"
                               autocomplete="one-time-code" placeholder=" " maxlength="6" required autofocus>
                        <label class="ff__label" for="code">6-digit code</label>
                    </div>

                    <x-button variant="primary" type="submit" size="lg" :block="true" class="auth__submit">Verify &amp; continue</x-button>
                </form>
            </li>
        </ol>
    </div>
</section>
@endsection
