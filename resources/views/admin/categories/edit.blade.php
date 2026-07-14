@extends('layouts.admin')

@section('title', 'Edit category')
@section('heading', 'Edit category')

@section('content')
    <div class="card max-w-lg p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-ink">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-input-brand" required autofocus>
                <p class="mt-1 text-xs text-gray-400">Current slug: <span class="font-mono">{{ $category->slug }}</span></p>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">Save changes</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
