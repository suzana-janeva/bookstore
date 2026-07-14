<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected Cart $cart)
    {
    }

    public function index()
    {
        return view('cart.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function add(Request $request, Book $book)
    {
        if (! $book->inStock()) {
            return back()->with('error', "\"{$book->title}\" is currently out of stock.");
        }

        $quantity = max(1, (int) $request->input('quantity', 1));
        $this->cart->add($book, $quantity);

        return back()->with('success', "\"{$book->title}\" added to your cart.");
    }

    public function update(Request $request, Book $book)
    {
        $quantity = (int) $request->input('quantity', 1);
        $this->cart->update($book, $quantity);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Book $book)
    {
        $this->cart->remove($book);

        return back()->with('success', 'Item removed from your cart.');
    }
}
