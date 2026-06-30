@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="auth">
    <div class="auth__head">
        <span class="auth__eyebrow">Get started</span>
        <h1 class="auth__title">Create your account</h1>
        <p class="auth__subtitle">Join SiteFueler and start shipping faster.</p>
    </div>

    @if ($errors->any())
        <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
    @endif

    <form method="post" action="{{ route('register.attempt') }}">
        @csrf

        <div class="ff">
            <input class="ff__input" id="name" name="name" type="text" placeholder=" " value="{{ old('name') }}" required autofocus>
            <label class="ff__label" for="name">Full name</label>
        </div>

        <div class="ff">
            <input class="ff__input" id="email" name="email" type="email" placeholder=" " value="{{ old('email') }}" required>
            <label class="ff__label" for="email">Email address</label>
        </div>

        <div class="ff">
            <input class="ff__input" id="password" name="password" type="password" placeholder=" " required>
            <label class="ff__label" for="password">Password</label>
        </div>

        <div class="ff">
            <input class="ff__input" id="password_confirmation" name="password_confirmation" type="password" placeholder=" " required>
            <label class="ff__label" for="password_confirmation">Confirm password</label>
        </div>

        <x-button variant="primary" type="submit" :block="true" class="auth__submit">Create account</x-button>
    </form>

    <div class="auth__divider">or continue with</div>

    <x-google-button label="Sign up with Google" />

    <p class="auth__alt">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </p>
</div>
@endsection
