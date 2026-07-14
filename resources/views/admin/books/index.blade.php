@extends('layouts.admin')

@section('title', 'Books')
@section('heading', 'Books')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-gray-500">{{ $books->total() }} {{ Str::plural('book', $books->total()) }}</p>
        <a href="{{ route('admin.books.create') }}" class="btn-primary">+ New book</a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-canvas text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3">Book</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Price</th>
                        <th class="px-5 py-3">Stock</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($books as $book)
                        <tr class="hover:bg-canvas">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $book->cover_url }}" alt="" class="h-12 w-9 rounded object-cover">
                                    <div>
                                        <p class="font-semibold text-ink">{{ $book->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $book->author }}</p>
                                    </div>
                                    @if($book->featured)<span class="badge">Featured</span>@endif
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $book->category?->name ?? '—' }}</td>
                            <td class="px-5 py-3 font-medium text-ink">${{ number_format($book->price, 2) }}</td>
                            <td class="px-5 py-3">
                                <span class="{{ $book->stock == 0 ? 'text-red-500 font-semibold' : ($book->stock <= 5 ? 'text-amber-600 font-semibold' : 'text-gray-600') }}">{{ $book->stock }}</span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.books.edit', $book) }}" class="font-medium text-brand-600 hover:text-brand-400">Edit</a>
                                    <form method="POST" action="{{ route('admin.books.destroy', $book) }}" onsubmit="return confirm('Delete this book?')">
                                        @csrf @method('DELETE')
                                        <button class="font-medium text-gray-400 hover:text-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-gray-500">No books yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $books->links() }}</div>
@endsection
