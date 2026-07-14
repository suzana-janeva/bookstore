@extends('layouts.store')

@section('title', 'Catalog')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <header class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-ink">
            {{ $activeCategory?->name ?? 'All books' }}
        </h1>
        <p class="mt-1 text-sm text-gray-500">{{ $books->total() }} {{ Str::plural('book', $books->total()) }} found</p>
    </header>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
        {{-- Sidebar filters --}}
        <aside class="lg:col-span-1">
            <form action="{{ route('books.index') }}" method="GET" class="card space-y-6 p-5">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Search</label>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Title or author"
                           class="form-input-brand text-sm">
                </div>

                <div>
                    <span class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-500">Category</span>
                    <div class="space-y-1.5">
                        <a href="{{ route('books.index', array_filter(['q' => $search, 'sort' => $sort])) }}"
                           class="block rounded-lg px-3 py-1.5 text-sm {{ ! $activeCategory ? 'bg-brand-50 font-semibold text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                            All categories
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('books.index', array_filter(['category' => $category->slug, 'q' => $search, 'sort' => $sort])) }}"
                               class="block rounded-lg px-3 py-1.5 text-sm {{ $activeCategory?->id === $category->id ? 'bg-brand-50 font-semibold text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-gray-500">Sort by</label>
                    <select name="sort" onchange="this.form.submit()" class="form-input-brand text-sm">
                        <option value="">Newest</option>
                        <option value="title" @selected($sort === 'title')>Title A–Z</option>
                        <option value="price_asc" @selected($sort === 'price_asc')>Price: low to high</option>
                        <option value="price_desc" @selected($sort === 'price_desc')>Price: high to low</option>
                    </select>
                </div>

                @if($activeCategory)
                    <input type="hidden" name="category" value="{{ $activeCategory->slug }}">
                @endif

                <button type="submit" class="btn-primary w-full">Apply</button>
                @if($search || $activeCategory || $sort)
                    <a href="{{ route('books.index') }}" class="block text-center text-sm text-gray-500 hover:text-brand-600">Clear filters</a>
                @endif
            </form>
        </aside>

        {{-- Results --}}
        <div class="lg:col-span-3">
            @if($books->isEmpty())
                <div class="card flex flex-col items-center justify-center py-24 text-center">
                    <p class="text-lg font-semibold text-ink">No books match your search.</p>
                    <p class="mt-1 text-sm text-gray-500">Try a different keyword or clear the filters.</p>
                    <a href="{{ route('books.index') }}" class="btn-secondary mt-6">Reset</a>
                </div>
            @else
                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3">
                    @foreach($books as $book)
                        <x-book-card :book="$book" />
                    @endforeach
                </div>
                <div class="mt-10">{{ $books->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
