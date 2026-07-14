@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    {{-- Stat cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['Revenue', '$' . number_format($stats['revenue'], 2), 'text-brand-600'],
                ['Total orders', $stats['total_orders'], 'text-ink'],
                ['Pending orders', $stats['pending_orders'], 'text-amber-600'],
                ['Customers', $stats['customers'], 'text-ink'],
            ];
        @endphp
        @foreach($cards as [$label, $value, $color])
            <div class="card p-5">
                <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
                <p class="mt-2 text-3xl font-extrabold {{ $color }}">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Low stock --}}
        <div class="card p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold text-ink">Low stock</h2>
                <span class="badge">≤ 5 left</span>
            </div>
            @if($lowStock->isEmpty())
                <p class="text-sm text-gray-500">Everything's well stocked. 🎉</p>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($lowStock as $book)
                        <div class="flex items-center justify-between py-3">
                            <a href="{{ route('admin.books.edit', $book) }}" class="text-sm font-medium text-ink hover:text-brand-600">{{ $book->title }}</a>
                            <span class="text-sm font-semibold {{ $book->stock == 0 ? 'text-red-500' : 'text-amber-600' }}">{{ $book->stock }} left</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Recent orders --}}
        <div class="card p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-bold text-ink">Recent orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-400">View all →</a>
            </div>
            @if($recentOrders->isEmpty())
                <p class="text-sm text-gray-500">No orders yet.</p>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-sm font-medium text-ink">#{{ $order->id }} · {{ $order->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-status-badge :status="$order->status" />
                                <span class="text-sm font-bold text-ink">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
