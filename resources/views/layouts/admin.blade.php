<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-canvas text-ink">
<div x-data="{ sidebar: false }" class="min-h-screen lg:flex">
    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full transform bg-ink text-white transition lg:static lg:translate-x-0"
           :class="sidebar && '!translate-x-0'">
        <div class="flex h-16 items-center gap-1.5 px-6">
            <span class="text-lg font-extrabold tracking-tight text-white">BookStore</span>
            <span class="text-lg font-extrabold tracking-tight text-brand-400">Admin</span>
        </div>
        @php
            $nav = [
                ['admin.dashboard', 'Dashboard', 'M3 12l9-9 9 9M5 10v10h14V10'],
                ['admin.books.index', 'Books', 'M4 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v14l-7-3-7 3V5z'],
                ['admin.categories.index', 'Categories', 'M4 6h16M4 12h16M4 18h16'],
                ['admin.orders.index', 'Orders', 'M3 3h2l.4 2M7 13h10l3-8H6.4M7 13 5.4 5M7 13l-2 5h12'],
                ['admin.users.index', 'Users', 'M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87m6-1.13a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z'],
            ];
        @endphp
        <nav class="space-y-1 px-3">
            @foreach($nav as [$route, $label, $icon])
                <a href="{{ route($route) }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                          {{ request()->routeIs(Str::beforeLast($route, '.') . '.*') || request()->routeIs($route) ? 'bg-brand-600 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                    {{ $label }}
                </a>
            @endforeach
        </nav>
        <div class="absolute inset-x-0 bottom-0 border-t border-white/10 p-3">
            <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7 7-7m-7 7h18"/></svg>
                Back to store
            </a>
        </div>
    </aside>

    {{-- Overlay for mobile --}}
    <div x-show="sidebar" @click="sidebar = false" x-cloak class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

    {{-- Main --}}
    <div class="flex-1">
        <header class="flex h-16 items-center justify-between border-b border-black/5 bg-white px-4 sm:px-6">
            <button @click="sidebar = true" class="rounded-lg p-2 text-gray-500 lg:hidden">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="text-lg font-bold text-ink">@yield('heading', 'Dashboard')</h1>
            <div class="flex items-center gap-3">
                <span class="hidden text-sm text-gray-500 sm:inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm font-medium text-gray-500 hover:text-brand-600">Log out</button>
                </form>
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-inside list-disc space-y-0.5">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<style>[x-cloak]{display:none!important;}</style>
</body>
</html>
