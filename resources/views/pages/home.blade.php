@extends('layouts.marketing')

{{-- SEO ----------------------------------------------------------------- --}}
@section('title', 'SiteFueler — Premium WordPress templates, plugins & growth tools')
@section('description', 'SiteFueler is the WordPress growth platform — premium templates, plugins, code snippets, tutorials, and expert services to help you build, customize, optimize, and grow your WordPress site faster.')
@section('og_title', 'SiteFueler — The WordPress Growth Platform')
@section('og_description', 'Premium templates, plugins, code snippets, tutorials, and expert services for WordPress builders.')
@section('twitter_title', 'SiteFueler — The WordPress Growth Platform')
@section('twitter_description', 'Premium templates, plugins, code snippets, tutorials, and expert services for WordPress builders.')

{{-- Structured data — Organization + WebSite (rich results) ------------- --}}
@php
    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => url('/') . '#organization',
                'name' => 'SiteFueler',
                'url' => url('/'),
                'logo' => asset('assets/images/logo.svg'),
                'description' => 'WordPress growth platform — premium templates, plugins, code snippets, tutorials, and expert services.',
            ],
            [
                '@type' => 'WebSite',
                '@id' => url('/') . '#website',
                'url' => url('/'),
                'name' => 'SiteFueler',
                'publisher' => ['@id' => url('/') . '#organization'],
                'inLanguage' => 'en-US',
            ],
        ],
    ];
@endphp
@push('jsonld')
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
<section class="hero" aria-labelledby="hero-title">
    <div class="hero__inner">
        <p class="hero__eyebrow">
            <span class="hero__eyebrow-dot" aria-hidden="true"></span>
            <span>WordPress Growth Platform</span>
        </p>

        <h1 id="hero-title" class="hero__title">
            Build, customize, and <span class="hero__highlight">grow</span> your WordPress site.
        </h1>

        <p class="hero__lead">
            Premium templates, polished plugins, ready-to-use code snippets, in-depth tutorials,
            and expert services — everything you need to ship faster and scale further, in one place.
        </p>

        <div class="hero__actions">
            <x-button variant="primary" size="lg" href="/templates">Browse templates</x-button>
            <x-button variant="ghost" size="lg" href="/plugins">Explore plugins</x-button>
        </div>

        <ul class="hero__chips" aria-label="What's inside">
            <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                <span>Templates</span>
            </li>
            <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3v6"/><path d="M18 3v6"/><path d="M4 9h16v4a8 8 0 0 1-16 0z"/><path d="M12 21v-4"/></svg>
                <span>Plugins</span>
            </li>
            <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                <span>Snippets</span>
            </li>
            <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <span>Tutorials</span>
            </li>
            <li>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                <span>Services</span>
            </li>
        </ul>
    </div>
</section>
@endsection
