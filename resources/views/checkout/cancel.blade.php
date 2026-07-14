@extends('layouts.store')

@section('title', 'Payment cancelled')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="card p-10 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
            <svg class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg>
        </div>
        <h1 class="mt-6 text-2xl font-extrabold tracking-tight text-ink">Payment cancelled</h1>
        <p class="mt-2 text-gray-600">Your order <span class="font-semibold text-ink">#{{ $order->id }}</span> is still pending. Your cart hasn't changed, so you can try again anytime.</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('checkout.index') }}" class="btn-primary">Try again</a>
            <a href="{{ route('cart.index') }}" class="btn-secondary">Back to cart</a>
        </div>
    </div>
</div>
@endsection
