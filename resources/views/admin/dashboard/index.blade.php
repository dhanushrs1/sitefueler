@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <div class="admin-stats">
        @foreach ($cards as $card)
            <div class="admin-stat">
                <div class="admin-stat__icon">
                    <x-admin.icon :name="$card['icon']" />
                </div>
                <div class="admin-stat__body">
                    <p class="admin-stat__label">{{ $card['label'] }}</p>
                    <p class="admin-stat__value">{{ $card['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="admin-panel">
        <h2 class="admin-panel__title">Welcome back</h2>
        <p class="admin-panel__text">
            This is the SiteFueler admin foundation. Business modules
            (Templates, Plugins, Services…) will appear here as they're built.
        </p>
    </div>
@endsection
