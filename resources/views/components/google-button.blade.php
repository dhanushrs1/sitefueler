@props([
    'label' => 'Continue with Google',
])

<a href="{{ route('oauth.redirect', 'google') }}" {{ $attributes->merge(['class' => 'auth__google']) }}>
    <svg viewBox="0 0 24 24" aria-hidden="true" width="18" height="18">
        <path fill="#EA4335" d="M12 10.2v3.9h5.4c-.24 1.4-1.6 4.1-5.4 4.1-3.25 0-5.9-2.7-5.9-6s2.65-6 5.9-6c1.85 0 3.1.8 3.8 1.5l2.6-2.5C16.7 2.9 14.6 2 12 2 6.9 2 2.8 6.1 2.8 11.2S6.9 20.4 12 20.4c5.9 0 9.8-4.15 9.8-10 0-.67-.07-1.18-.16-1.7H12z"/>
    </svg>
    <span>{{ $label }}</span>
</a>
