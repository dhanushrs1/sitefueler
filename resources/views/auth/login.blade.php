@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth">
    <div class="auth__head">
        <span class="auth__eyebrow">Sign in</span>
        <h1 class="auth__title">Good to see you again</h1>
        <p class="auth__subtitle">Pick up right where you left off.</p>
    </div>

    @if ($errors->any())
        <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
    @endif

    <form method="post" action="{{ route('login.attempt') }}">
        @csrf

        <div class="ff">
            <input class="ff__input" id="email" name="email" type="email" placeholder=" " value="{{ old('email') }}" required autofocus>
            <label class="ff__label" for="email">Email address</label>
        </div>

        <div class="ff">
            <input class="ff__input" id="password" name="password" type="password" placeholder=" " required>
            <label class="ff__label" for="password">Password</label>
        </div>

        <div class="auth__row">
            <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <x-button variant="primary" type="submit" :block="true">Sign in</x-button>
    </form>

    <div class="auth__divider">or continue with</div>

    <x-google-button label="Continue with Google" />

    <p class="auth__alt">
        New to SiteFueler? <a href="{{ route('register') }}">Create an account</a>
    </p>
</div>
@endsection
