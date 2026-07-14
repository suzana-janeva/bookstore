<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="space-y-5 lg:col-span-2">
        <div>
            <label class="mb-1.5 block text-sm font-semibold text-ink">Title</label>
            <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" class="form-input-brand" required>
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-semibold text-ink">Author</label>
            <input type="text" name="author" value="{{ old('author', $book->author ?? '') }}" class="form-input-brand" required>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-ink">Price ($)</label>
                <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $book->price ?? '') }}" class="form-input-brand" required>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-ink">Stock</label>
                <input type="number" min="0" name="stock" value="{{ old('stock', $book->stock ?? 0) }}" class="form-input-brand" required>
            </div>
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-semibold text-ink">Description</label>
            <textarea name="description" rows="5" class="form-input-brand">{{ old('description', $book->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="space-y-5 lg:col-span-1">
        <div>
            <label class="mb-1.5 block text-sm font-semibold text-ink">Category</label>
            <select name="category_id" class="form-input-brand">
                <option value="">Uncategorised</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-semibold text-ink">Cover image</label>
            <img id="cover-preview" alt=""
                 src="{{ !empty($book) && $book->cover_image ? $book->cover_url : '' }}"
                 class="mb-3 h-40 w-28 rounded-lg object-cover shadow-sm {{ !empty($book) && $book->cover_image ? '' : 'hidden' }}">
            <input type="file" name="cover_image" accept="image/*" id="cover-input"
                   class="block w-full text-sm text-gray-500 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100">
            <p class="mt-1 text-xs text-gray-400">JPG/PNG, up to 4 MB. Leave blank to keep the current image.</p>
        </div>

        <script>
            document.getElementById('cover-input').addEventListener('change', function (event) {
                const file = event.target.files[0];
                const preview = document.getElementById('cover-preview');

                if (!file) {
                    return;
                }

                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            });
        </script>

        <label class="flex items-center gap-3 rounded-lg border border-gray-200 p-3">
            <input type="checkbox" name="featured" value="1" @checked(old('featured', $book->featured ?? false))
                   class="rounded border-gray-300 text-brand-600 focus:ring-brand-400">
            <span class="text-sm font-medium text-ink">Feature on homepage</span>
        </label>
    </div>
</div>

<div class="mt-8 flex items-center gap-3">
    <button type="submit" class="btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.books.index') }}" class="btn-secondary">Cancel</a>
</div>
