@extends('layouts.store')

@section('title', 'Home')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-50 via-white to-white"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
            <div class="max-w-2xl">
                <span class="badge mb-5">Handpicked reads</span>
                <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Find your next<br><span class="text-brand-600">favourite book.</span>
                </h1>
                <p class="mt-6 max-w-lg text-lg leading-relaxed text-gray-600">
                    A carefully curated shelf of fiction, ideas and stories worth your time — delivered with care.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('books.index') }}" class="btn-primary">Browse the catalog</a>
                    @guest
                        <a href="{{ route('register') }}" class="btn-secondary">Create an account</a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    @if($categories->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-3">
                @foreach($categories as $category)
                    <a href="{{ route('books.index', ['category' => $category->slug]) }}"
                       class="group flex items-center gap-2 rounded-full border border-brand-100 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:border-brand-400 hover:text-brand-600">
                        {{ $category->name }}
                        <span class="rounded-full bg-brand-50 px-2 py-0.5 text-xs text-brand-600">{{ $category->books_count }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Featured --}}
    <section class="mx-auto max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-end justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-ink">Featured this week</h2>
                <p class="mt-1 text-sm text-gray-500">Our editors' current picks.</p>
            </div>
            <a href="{{ route('books.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-400">View all →</a>
        </div>
        <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($featured as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>
    </section>

    {{-- New arrivals --}}
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h2 class="mb-6 text-2xl font-bold tracking-tight text-ink">New arrivals</h2>
        <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($newArrivals as $book)
                <x-book-card :book="$book" />
            @endforeach
        </div>
    </section>
@endsection
