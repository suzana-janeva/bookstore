<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $user = $request->user();

        if (! $user->hasPurchased($book)) {
            return back()->with('error', 'You can only review books you have purchased.');
        }

        if ($book->reviews()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'You have already reviewed this book.');
        }

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        $book->reviews()->create([
            'user_id' => $user->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return back()->with('success', 'Thanks for your review!');
    }
}
