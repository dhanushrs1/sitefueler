@extends('layouts.marketing')

@section('title', 'Your recovery codes')

@section('content')
<section class="auth-page">
    <div class="auth">
        <div class="auth__head">
            <span class="auth__eyebrow">Security</span>
            <h1 class="auth__title">Save your recovery codes</h1>
            <p class="auth__subtitle">Keep these somewhere safe. Each code works once if you ever lose access to your authenticator app.</p>
        </div>

        <x-alert variant="warning" class="mb-16">These codes are shown only once. Store them now.</x-alert>

        <ul class="tfa-codes">
            @foreach ($codes as $code)
                <li class="tfa-codes__item">{{ $code }}</li>
            @endforeach
        </ul>

        <a class="gbtn mb-16"
           download="sitefueler-recovery-codes.txt"
           href="data:text/plain;charset=utf-8,{{ rawurlencode(implode(PHP_EOL, $codes)) }}">
            Download codes (.txt)
        </a>

        <x-button variant="primary" size="lg" :block="true" :href="$continueUrl" class="auth__continue">
            I've saved them — continue
        </x-button>
    </div>
</section>
@endsection
