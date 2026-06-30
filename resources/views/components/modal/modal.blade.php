@props([
    'id',                      {{-- required: used to open via data-modal-open="id" --}}
    'size' => 'md',            {{-- sm | md | lg --}}
    'title' => null,
    'closeOnBackdrop' => true, {{-- false for critical/confirmation modals --}}
])

{{--
    Open with any trigger:   <x-button data-modal-open="{{ $id }}">Open</x-button>
    Close from inside:       data-modal-close on a button (Cancel / X)
--}}

<dialog
    id="{{ $id }}"
    class="modal modal--{{ $size }}"
    @if ($title) aria-labelledby="{{ $id }}-title" @endif
    @unless ($closeOnBackdrop) data-no-backdrop-close @endunless
    {{ $attributes }}
>
    <div class="modal__dialog">
        <header class="modal__header">
            @if ($title)
                <h2 class="modal__title" id="{{ $id }}-title">{{ $title }}</h2>
            @endif
            <button type="button" class="modal__close" data-modal-close aria-label="Close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </header>

        <div class="modal__body">
            {{ $slot }}
        </div>

        @isset($footer)
            <footer class="modal__footer">{{ $footer }}</footer>
        @endisset
    </div>
</dialog>
