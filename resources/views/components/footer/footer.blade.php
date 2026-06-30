@php
    $columns = config('navigation.footer', []);
    $legal = config('navigation.legal', []);
@endphp

<footer class="site-footer">

    {{-- CTA card (overlaps the page/footer seam) --}}
    <div class="footer-cta-band">
        <div class="container">
            <div class="footer-cta">
                <div class="footer-cta__intro">
                    <h2 class="footer-cta__title">Need a custom website or service?</h2>
                    <p class="footer-cta__subtitle">Tell us about your project and get a free quote.</p>
                </div>

                <form class="footer-cta__form" action="/quote" method="post">
                    <div class="footer-cta__row">
                        <x-form.input name="name" placeholder="Name" aria-label="Name" />
                        <x-form.input name="email" type="email" placeholder="Email" aria-label="Email" />
                        <x-form.input name="phone" type="tel" placeholder="Mobile number" aria-label="Mobile number" />
                    </div>
                    <x-form.textarea name="details" rows="4" aria-label="Project details"
                        placeholder="Tell us about your project — type of website, references, and budget." />
                    <div class="footer-cta__actions">
                        <x-button variant="secondary" type="submit">Submit</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Main footer (dark) --}}
    <div class="site-footer__main">
        <div class="container">
            <div class="site-footer__cols">
                {{-- Brand column --}}
                <div class="site-footer__brand">
                    <a href="/" class="site-footer__logo" aria-label="SiteFueler home">
                        <x-logo tone="light" />
                    </a>
                    <p class="site-footer__desc">
                        Modern templates, plugins, and services for WordPress and beyond —
                        crafted to help you launch faster.
                    </p>
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
    </div>
</footer>
