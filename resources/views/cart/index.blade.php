@extends('layouts.store')

@section('title', 'Your cart')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold tracking-tight text-ink">Your cart</h1>

    @if($items->isEmpty())
        <div class="card mt-8 flex flex-col items-center justify-center py-24 text-center">
            <p class="text-lg font-semibold text-ink">Your cart is empty.</p>
            <p class="mt-1 text-sm text-gray-500">Browse the shelf and add something you'll love.</p>
            <a href="{{ route('books.index') }}" class="btn-primary mt-6">Browse books</a>
        </div>
    @else
        <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
            {{-- Line items --}}
            <div class="space-y-4 lg:col-span-2">
                @foreach($items as $line)
                    <div class="card flex gap-4 p-4">
                        <a href="{{ route('books.show', $line->book) }}" class="shrink-0">
                            <img src="{{ $line->book->cover_url }}" alt="{{ $line->book->title }}"
                                 class="h-28 w-20 rounded-lg object-cover">
                        </a>
                        <div class="flex flex-1 flex-col justify-between">
                            <div>
                                <a href="{{ route('books.show', $line->book) }}" class="font-semibold text-ink hover:text-brand-600">{{ $line->book->title }}</a>
                                <p class="text-sm text-gray-500">{{ $line->book->author }}</p>
                                <p class="mt-1 text-sm font-medium text-ink">${{ number_format($line->book->price, 2) }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <form method="POST" action="{{ route('cart.update', $line->book) }}" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $line->quantity }}" min="1" max="{{ $line->book->stock }}"
                                           class="w-20 rounded-lg border-gray-200 text-center text-sm focus:border-brand-400 focus:ring-brand-400"
                                           onchange="this.form.submit()">
                                    <span class="text-xs text-gray-400">Update</span>
                                </form>
                                <form method="POST" action="{{ route('cart.remove', $line->book) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-gray-400 hover:text-red-500">Remove</button>
                                </form>
                            </div>
                        </div>
                        <div class="shrink-0 text-right">
                            <p class="font-bold text-ink">${{ number_format($line->subtotal, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="card sticky top-24 space-y-4 p-6">
                    <h2 class="text-lg font-bold text-ink">Order summary</h2>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-semibold text-ink">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Shipping</span>
                        <span class="text-gray-400">Calculated at checkout</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        <div class="flex justify-between text-base font-bold text-ink">
                            <span>Total</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn-primary w-full">Proceed to checkout</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full">Log in to checkout</a>
                    @endauth
                    <a href="{{ route('books.index') }}" class="block text-center text-sm text-gray-500 hover:text-brand-600">Continue shopping</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
