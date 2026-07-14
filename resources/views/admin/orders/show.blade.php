@extends('layouts.admin')

@section('title', 'Order #' . $order->id)
@section('heading', 'Order #' . $order->id)

@section('content')
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-brand-600">← Back to orders</a>

    <div class="mt-4 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Items --}}
        <div class="lg:col-span-2">
            <div class="card divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4">
                        <img src="{{ $item->book?->cover_url }}" alt="" class="h-16 w-11 rounded object-cover">
                        <div class="flex-1">
                            <p class="font-semibold text-ink">{{ $item->book?->title ?? 'Book' }}</p>
                            <p class="text-sm text-gray-500">Qty {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                        </div>
                        <p class="font-bold text-ink">${{ number_format($item->subtotal(), 2) }}</p>
                    </div>
                @endforeach
                <div class="flex justify-between p-4 text-base font-bold text-ink">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6 lg:col-span-1">
            <div class="card p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Update status</h2>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="mt-4 space-y-3">
                    @csrf @method('PATCH')
                    <select name="status" class="form-input-brand">
                        @foreach(\App\Models\Order::STATUSES as $status)
                            <option value="{{ $status }}" @selected($order->status === $status) class="capitalize">{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-primary w-full">Update</button>
                </form>
            </div>

            <div class="card p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Customer</h2>
                <p class="mt-3 text-sm font-medium text-ink">{{ $order->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
            </div>

            @if($order->shipping_address)
                <div class="card p-6">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Shipping</h2>
                    <p class="mt-3 whitespace-pre-line text-sm text-gray-700">{{ $order->shipping_address }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
