@extends('layouts.marketing')

@section('title', 'Two-factor authentication')

@section('content')
<section class="auth-page">
    <div class="auth">
        <div class="auth__head">
            <span class="auth__eyebrow">Verify it's you</span>
            <h1 class="auth__title">Enter your code</h1>
            <p class="auth__subtitle">Open your authenticator app and enter the 6-digit code. You can also use a recovery code.</p>
        </div>

        @if ($errors->any())
            <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
        @endif

        <form method="post" action="{{ route('two-factor.challenge.verify') }}">
            @csrf

            <div class="ff">
                <input class="ff__input" id="code" name="code" type="text" inputmode="text"
                       autocomplete="one-time-code" placeholder=" " required autofocus>
                <label class="ff__label" for="code">6-digit code or recovery code</label>
            </div>

            <label class="tfa-remember">
                <input type="checkbox" name="remember_device" value="1">
                <span>Trust this device for 30 days</span>
            </label>

            <x-button variant="primary" type="submit" size="lg" :block="true" class="auth__submit">Verify</x-button>
        </form>

        <p class="auth__alt">
            Having trouble? <a href="{{ route('login') }}">Sign in again</a>
        </p>
    </div>
</section>
@endsection
