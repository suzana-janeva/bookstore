<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Book::with('category')
            ->where('featured', true)
            ->latest()
            ->take(4)
            ->get();

        if ($featured->isEmpty()) {
            $featured = Book::with('category')->latest()->take(4)->get();
        }

        $newArrivals = Book::with('category')->latest()->take(8)->get();

        $categories = Category::withCount('books')->orderBy('name')->get();

        return view('home', compact('featured', 'newArrivals', 'categories'));
    }
}
