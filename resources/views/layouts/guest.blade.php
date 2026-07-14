<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full min-h-screen flex flex-col bg-canvas text-ink font-sans antialiased">
        @include('layouts.partials.navbar', ['showSearch' => false])

        <div class="flex flex-1 flex-col items-center justify-center px-6 py-12">
            <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-card ring-1 ring-black/5 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>

        <style>[x-cloak]{display:none!important;}</style>
    </body>
</html>
