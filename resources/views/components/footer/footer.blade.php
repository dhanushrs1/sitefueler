@php
    $columns = config('navigation.footer', []);
    $legal = config('navigation.legal', []);
@endphp

<footer class="site-footer">
    <div class="container">
        <div class="site-footer__cols">
            {{-- Brand column --}}
            <div class="site-footer__brand">
                <a href="/" class="site-footer__logo" aria-label="SiteFueler home">
                    <x-logo tone="light" />
                </a>
                <p class="site-footer__desc">
                    Modern templates, plugins, and services for WordPress and beyond.
                </p>
                <x-button variant="primary" size="sm" href="/get-started">Get Started</x-button>
            </div>

            {{-- Link columns (from config) --}}
            @foreach ($columns as $heading => $links)
                <nav class="site-footer__col" aria-label="{{ $heading }}">
                    <p class="site-footer__heading">{{ $heading }}</p>
                    <ul class="site-footer__list">
                        @foreach ($links as $link)
                            <li><a class="site-footer__link" href="{{ $link['url'] }}">{{ $link['title'] }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            @endforeach
        </div>

        {{-- Bottom bar --}}
        <div class="site-footer__bottom">
            <span>&copy; {{ date('Y') }} SiteFueler. All rights reserved.</span>
            <nav class="site-footer__legal" aria-label="Legal">
                @foreach ($legal as $link)
                    <a class="site-footer__link" href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                @endforeach
            </nav>
        </div>
    </div>
</footer>
