@extends('layouts.admin')

@section('title', 'Categories')
@section('heading', 'Categories')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-gray-500">{{ $categories->total() }} {{ Str::plural('category', $categories->total()) }}</p>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ New category</a>
    </div>

    <div class="card overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-canvas text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Slug</th>
                    <th class="px-5 py-3">Books</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-canvas">
                        <td class="px-5 py-3 font-semibold text-ink">{{ $category->name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $category->slug }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $category->books_count }}</td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="font-medium text-brand-600 hover:text-brand-400">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? Books will become uncategorised.')">
                                    @csrf @method('DELETE')
                                    <button class="font-medium text-gray-400 hover:text-red-500">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-12 text-center text-gray-500">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
@endsection
