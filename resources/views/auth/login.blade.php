@extends('layouts.marketing')

@section('title', 'Login')

@section('content')
<section class="auth">
    <div class="container">
        <div class="auth__card">
            <h1 class="auth__title">Welcome Back</h1>
            <p class="auth__subtitle">Sign in to your SiteFueler account.</p>

            @if ($errors->any())
                <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
            @endif

            <form method="post" action="{{ route('login.attempt') }}">
                @csrf

                <x-form.input
                    name="email"
                    type="email"
                    label="Email"
                    placeholder="you@example.com"
                    :value="old('email')"
                    required
                />

                <x-form.input
                    name="password"
                    type="password"
                    label="Password"
                    placeholder="••••••••"
                    required
                />

                <div class="auth__forgot">
                    <a href="#">Forgot Password?</a>
                </div>

                <x-button variant="primary" type="submit" :block="true">Login</x-button>
            </form>

            <div class="auth__divider">OR</div>

            <x-google-button label="Continue with Google" />

            <p class="auth__alt">
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </p>
        </div>
    </div>
</section>
@endsection
