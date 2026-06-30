@extends('layouts.marketing')

@section('title', 'Dashboard')

@section('content')
<x-page-title title="My Dashboard" subtitle="Welcome back, {{ auth()->user()->name }}.">
    <x-slot:actions>
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <x-button variant="ghost" type="submit">Logout</x-button>
        </form>
    </x-slot:actions>
</x-page-title>

<section class="section">
    <div class="container">
        <div class="grid">
            @foreach (['Profile', 'Orders', 'Downloads', 'Wishlist', 'Settings', 'Connected Accounts'] as $module)
                <x-card.card>
                    <h3 class="card__title">{{ $module }}</h3>
                    <p class="card__text">Coming soon.</p>
                </x-card.card>
            @endforeach
        </div>
    </div>
</section>
@endsection
