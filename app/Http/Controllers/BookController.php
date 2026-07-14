<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Book::with('category');

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $activeCategory = null;
        if ($categorySlug = $request->input('category')) {
            $activeCategory = Category::where('slug', $categorySlug)->first();
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'title':
                $query->orderBy('title');
                break;
            default:
                $query->latest();
        }

        $books = $query->paginate(9)->withQueryString();

        return view('books.index', [
            'books' => $books,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'search' => $search,
            'sort' => $request->input('sort'),
        ]);
    }

    public function show(Book $book)
    {
        $book->load(['category', 'reviews.user']);

        $canReview = false;
        $hasReviewed = false;

        if ($user = auth()->user()) {
            $hasReviewed = $book->reviews()->where('user_id', $user->id)->exists();
            $canReview = ! $hasReviewed && $user->hasPurchased($book);
        }

        $related = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        return view('books.show', compact('book', 'canReview', 'hasReviewed', 'related'));
    }
}
