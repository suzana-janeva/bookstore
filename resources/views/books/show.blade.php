@extends('layouts.store')

@section('title', $book->title)

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-brand-600">Home</a>
        <span>/</span>
        <a href="{{ route('books.index') }}" class="hover:text-brand-600">Books</a>
        @if($book->category)
            <span>/</span>
            <a href="{{ route('books.index', ['category' => $book->category->slug]) }}" class="hover:text-brand-600">{{ $book->category->name }}</a>
        @endif
    </nav>

    <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
        {{-- Cover --}}
        <div class="lg:col-span-4">
            <div class="overflow-hidden rounded-2xl bg-brand-50 shadow-card">
                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="aspect-[2/3] w-full object-cover">
            </div>
        </div>

        {{-- Details --}}
        <div class="lg:col-span-8">
            @if($book->category)
                <a href="{{ route('books.index', ['category' => $book->category->slug]) }}" class="badge">{{ $book->category->name }}</a>
            @endif
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-ink sm:text-4xl">{{ $book->title }}</h1>
            <p class="mt-2 text-lg text-gray-600">by {{ $book->author }}</p>

            <div class="mt-4 flex items-center gap-3">
                <x-stars :rating="$book->averageRating()" :count="$book->reviews->count()" />
            </div>

            <div class="mt-6 flex items-baseline gap-3">
                <span class="text-4xl font-extrabold text-ink">${{ number_format($book->price, 2) }}</span>
                @if($book->inStock())
                    <span class="text-sm font-medium text-green-600">In stock · {{ $book->stock }} available</span>
                @else
                    <span class="text-sm font-semibold uppercase tracking-wide text-red-500">Out of stock</span>
                @endif
            </div>

            @if($book->description)
                <p class="mt-6 max-w-2xl leading-relaxed text-gray-700">{{ $book->description }}</p>
            @endif

            @if($book->inStock())
                <form method="POST" action="{{ route('cart.add', $book) }}" class="mt-8 flex items-center gap-3">
                    @csrf
                    <div class="flex items-center rounded-lg border border-gray-200">
                        <label for="qty" class="sr-only">Quantity</label>
                        <input id="qty" type="number" name="quantity" value="1" min="1" max="{{ $book->stock }}"
                               class="w-20 rounded-lg border-0 text-center focus:ring-0">
                    </div>
                    <button type="submit" class="btn-primary">Add to cart</button>
                </form>
            @else
                <button disabled class="btn-primary mt-8">Currently unavailable</button>
            @endif
        </div>
    </div>

    {{-- Reviews --}}
    <section class="mt-16 border-t border-black/5 pt-10">
        <h2 class="text-2xl font-bold tracking-tight text-ink">Reviews</h2>

        {{-- Leave a review --}}
        <div class="mt-6 max-w-2xl">
            @auth
                @if($canReview)
                    <form method="POST" action="{{ route('reviews.store', $book) }}" class="card space-y-4 p-6">
                        @csrf
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-ink">Your rating</label>
                            <select name="rating" class="form-input-brand max-w-[10rem]">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-ink">Comment</label>
                            <textarea name="comment" rows="3" class="form-input-brand" placeholder="What did you think?"></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Submit review</button>
                    </form>
                @elseif($hasReviewed)
                    <p class="rounded-lg bg-brand-50 px-4 py-3 text-sm text-brand-700">You've already reviewed this book — thank you!</p>
                @else
                    <p class="rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-600">You can review this book once you've purchased it.</p>
                @endif
            @else
                <p class="rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:underline">Log in</a> to leave a review.
                </p>
            @endauth
        </div>

        {{-- Review list --}}
        <div class="mt-8 space-y-5">
            @forelse($book->reviews->sortByDesc('created_at') as $review)
                <div class="card p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">
                                {{ Str::upper(Str::substr($review->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-ink">{{ $review->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $review->created_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                        <x-stars :rating="$review->rating" />
                    </div>
                    @if($review->comment)
                        <p class="mt-3 text-sm leading-relaxed text-gray-700">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">No reviews yet. Be the first to share your thoughts.</p>
            @endforelse
        </div>
    </section>

    {{-- Related --}}
    @if($related->isNotEmpty())
        <section class="mt-16">
            <h2 class="mb-6 text-2xl font-bold tracking-tight text-ink">You might also like</h2>
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach($related as $rel)
                    <x-book-card :book="$rel" />
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
