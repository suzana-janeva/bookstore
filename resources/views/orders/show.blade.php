@extends('layouts.store')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
    <a href="{{ route('orders.index') }}" class="text-sm text-gray-500 hover:text-brand-600">← Back to orders</a>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-ink">Order #{{ $order->id }}</h1>
            <p class="mt-1 text-sm text-gray-500">Placed {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
        <x-status-badge :status="$order->status" class="!text-sm !px-3 !py-1" />
    </div>

    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="card divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4">
                        <img src="{{ $item->book?->cover_url }}" alt="" class="h-20 w-14 rounded-lg object-cover">
                        <div class="flex-1">
                            <p class="font-semibold text-ink">{{ $item->book?->title ?? 'Book' }}</p>
                            <p class="text-sm text-gray-500">{{ $item->book?->author }}</p>
                            <p class="text-sm text-gray-500">Qty {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                        </div>
                        <p class="font-bold text-ink">${{ number_format($item->subtotal(), 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6 lg:col-span-1">
            <div class="card p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Summary</h2>
                <div class="mt-4 flex justify-between text-base font-bold text-ink">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
            @if($order->shipping_address)
                <div class="card p-6">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Shipping to</h2>
                    <p class="mt-3 whitespace-pre-line text-sm text-gray-700">{{ $order->shipping_address }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
