@props(['book'])

<article class="group card overflow-hidden transition duration-200 hover:-translate-y-1 hover:shadow-card-hover">
    <a href="{{ route('books.show', $book) }}" class="block">
        <div class="aspect-[2/3] overflow-hidden rounded-t-2xl bg-brand-50">
            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
        </div>
    </a>
    <div class="space-y-2 p-4">
        @if($book->category)
            <span class="badge">{{ $book->category->name }}</span>
        @endif
        <h3 class="line-clamp-2 font-semibold leading-snug text-ink">
            <a href="{{ route('books.show', $book) }}" class="hover:text-brand-600">{{ $book->title }}</a>
        </h3>
        <p class="text-sm text-gray-500">{{ $book->author }}</p>
        <div class="flex items-center justify-between pt-1">
            <span class="text-lg font-bold text-ink">${{ number_format($book->price, 2) }}</span>
            @if($book->inStock())
                <form method="POST" action="{{ route('cart.add', $book) }}">
                    @csrf
                    <button type="submit" class="btn-primary !px-3 !py-1.5 text-xs">Add</button>
                </form>
            @else
                <span class="text-xs font-semibold uppercase tracking-wide text-red-500">Sold out</span>
            @endif
        </div>
    </div>
</article>
