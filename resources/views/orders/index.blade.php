@extends('layouts.store')

@section('title', 'My orders')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold tracking-tight text-ink">My orders</h1>

    @if($orders->isEmpty())
        <div class="card mt-8 flex flex-col items-center justify-center py-24 text-center">
            <p class="text-lg font-semibold text-ink">No orders yet.</p>
            <p class="mt-1 text-sm text-gray-500">When you place an order, it'll show up here.</p>
            <a href="{{ route('books.index') }}" class="btn-primary mt-6">Start shopping</a>
        </div>
    @else
        <div class="mt-8 space-y-4">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="card block p-5 transition hover:shadow-card-hover">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="font-bold text-ink">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y') }} · {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-status-badge :status="$order->status" />
                            <span class="text-lg font-bold text-ink">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-3 flex -space-x-3">
                        @foreach($order->items->take(5) as $item)
                            <img src="{{ $item->book?->cover_url }}" alt="" class="h-12 w-9 rounded border-2 border-white object-cover shadow-sm">
                        @endforeach
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
