@props([
    'caption' => null,    {{-- accessible description of the table --}}
    'loading' => false,
])

{{--
    Usage:
    <x-table.table caption="Orders">
        <x-slot:head>
            <tr><th>ID</th><th>Customer</th><th>Status</th></tr>
        </x-slot:head>
        <tr><td>#1</td><td>Jane</td><td><x-badge variant="new" /></td></tr>
    </x-table.table>

    Provide an empty state by passing the `empty` slot instead of rows.
--}}

<div {{ $attributes->merge(['class' => 'table-wrap' . ($loading ? ' is-loading' : '')]) }}>
    <table class="table">
        @if ($caption)
            <caption class="table__caption">{{ $caption }}</caption>
        @endif

        @isset($head)
            <thead>{{ $head }}</thead>
        @endisset

        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
