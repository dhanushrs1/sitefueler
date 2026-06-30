@extends('layouts.auth')

@section('title', 'Forgot password')

@section('content')
<div class="auth">
    <div class="auth__head">
        <span class="auth__eyebrow">Account recovery</span>
        <h1 class="auth__title">Reset your password</h1>
        <p class="auth__subtitle">Enter your email and we'll send you a secure link to set a new password.</p>
    </div>

    @if (session('status'))
        <x-alert variant="success" class="mb-16">{{ session('status') }}</x-alert>
    @endif

    @if ($errors->any())
        <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
    @endif

    <form method="post" action="{{ route('password.email') }}">
        @csrf

        <div class="ff">
            <input class="ff__input" id="email" name="email" type="email" placeholder=" " value="{{ old('email') }}" required autofocus>
            <label class="ff__label" for="email">Email address</label>
        </div>

        <x-button variant="primary" type="submit" :block="true" class="auth__submit">Send reset link</x-button>
    </form>

    <p class="auth__alt">
        Remembered it? <a href="{{ route('login') }}">Back to sign in</a>
    </p>
</div>
@endsection
