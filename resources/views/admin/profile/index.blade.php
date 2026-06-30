@extends('admin.layouts.app')

@section('title', 'Profile')
@section('page_title', 'Profile')

@section('content')
    <div class="admin-panel" style="max-width: 560px;">
        @if (session('status'))
            <x-alert variant="success" class="mb-16">{{ session('status') }}</x-alert>
        @endif

        @if ($errors->any())
            <x-alert variant="danger" class="mb-16">{{ $errors->first() }}</x-alert>
        @endif

        <form method="post" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('put')

            <x-form.input name="name" label="Name" :value="old('name', $user->name)" required />
            <x-form.input name="email" type="email" label="Email" :value="old('email', $user->email)" required />

            <x-button variant="primary" type="submit" class="mt-8">Save changes</x-button>
        </form>
    </div>
@endsection
