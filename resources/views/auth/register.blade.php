@extends('layouts.marketing')

@section('title', 'Register')

@section('content')
<section class="auth">
    <div class="container">
        <div class="auth__card">
            <h1 class="auth__title">Create your account</h1>
            <p class="auth__subtitle">Join SiteFueler in a few seconds.</p>

            @if ($errors->any())
                <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
            @endif

            <form method="post" action="{{ route('register.attempt') }}">
                @csrf

                <x-form.input name="name" label="Name" placeholder="Jane Doe" :value="old('name')" required />
                <x-form.input name="email" type="email" label="Email" placeholder="you@example.com" :value="old('email')" required />
                <x-form.input name="password" type="password" label="Password" placeholder="••••••••" required />
                <x-form.input name="password_confirmation" type="password" label="Confirm password" placeholder="••••••••" required />

                <x-button variant="primary" type="submit" :block="true" class="mt-8">Create account</x-button>
            </form>

            <div class="auth__divider">OR</div>

            <x-google-button label="Continue with Google" />

            <p class="auth__alt">
                Already have an account? <a href="{{ route('login') }}">Login</a>
            </p>
        </div>
    </div>
</section>
@endsection
