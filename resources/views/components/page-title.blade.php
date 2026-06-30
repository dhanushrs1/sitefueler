@props([
    'title',
    'subtitle' => null,
])

<section {{ $attributes->merge(['class' => 'page-title']) }}>
    <div class="container">
        @isset($breadcrumb)
            <div class="page-title__breadcrumb">{{ $breadcrumb }}</div>
        @endisset

        <div class="page-title__inner">
            <div>
                <h1 class="page-title__heading">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="page-title__subtitle">{{ $subtitle }}</p>
                @endif
            </div>

            @isset($actions)
                <div class="page-title__actions">{{ $actions }}</div>
            @endisset
        </div>
    </div>
</section>
