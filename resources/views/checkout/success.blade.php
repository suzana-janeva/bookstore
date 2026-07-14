@extends('layouts.store')

@section('title', 'Order confirmed')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="card p-10 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7"/></svg>
        </div>
        <h1 class="mt-6 text-2xl font-extrabold tracking-tight text-ink">Thank you for your order!</h1>
        <p class="mt-2 text-gray-600">Order <span class="font-semibold text-ink">#{{ $order->id }}</span> has been confirmed and paid.</p>

        <div class="mt-8 space-y-3 rounded-xl bg-canvas p-5 text-left">
            @foreach($order->items as $item)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">{{ $item->book?->title ?? 'Book' }} <span class="text-gray-400">× {{ $item->quantity }}</span></span>
                    <span class="font-medium text-ink">${{ number_format($item->subtotal(), 2) }}</span>
                </div>
            @endforeach
            <div class="flex justify-between border-t border-gray-200 pt-3 text-base font-bold text-ink">
                <span>Total</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('orders.show', $order) }}" class="btn-primary">View order</a>
            <a href="{{ route('books.index') }}" class="btn-secondary">Keep shopping</a>
        </div>
    </div>
</div>
@endsection
