<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Bookshelf')  · {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full min-h-screen flex flex-col bg-canvas text-ink">

    @include('layouts.partials.navbar')

    {{-- Flash messages --}}
    @if(session('success') || session('error') || $errors->any())
        <div class="mx-auto w-full max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <ul class="list-inside list-disc space-y-0.5">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-16 border-t border-black/5 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 py-10 sm:flex-row sm:px-6 lg:px-8">
            <div class="flex items-baseline gap-1.5">
                <span class="text-lg font-extrabold tracking-tight text-brand-600">Bookstore</span>
            </div>
            <p class="text-sm text-gray-500">© {{ date('Y') }} · Curated reads, beautifully delivered.</p>
        </div>
    </footer>

    <style>[x-cloak]{display:none!important;}</style>
</body>
</html>
