@extends('layouts.store')

@section('title', 'Profile')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold tracking-tight text-ink">Profile</h1>

    <div class="mt-8 space-y-6">
        <div class="card p-4 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card p-4 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endsection
