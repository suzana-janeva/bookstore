@extends('layouts.admin')

@section('title', 'Orders')
@section('heading', 'Orders')

@section('content')
    {{-- Status filter --}}
    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.orders.index') }}"
           class="rounded-full px-4 py-1.5 text-sm font-medium {{ ! $activeStatus ? 'bg-brand-600 text-white' : 'bg-white text-gray-600 ring-1 ring-black/5 hover:text-brand-600' }}">
            All
        </a>
        @foreach($statuses as $status)
            <a href="{{ route('admin.orders.index', ['status' => $status]) }}"
               class="rounded-full px-4 py-1.5 text-sm font-medium capitalize {{ $activeStatus === $status ? 'bg-brand-600 text-white' : 'bg-white text-gray-600 ring-1 ring-black/5 hover:text-brand-600' }}">
                {{ $status }}
            </a>
        @endforeach
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-canvas text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3">Order</th>
                        <th class="px-5 py-3">Customer</th>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3">Total</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-canvas">
                            <td class="px-5 py-3 font-semibold text-ink">#{{ $order->id }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $order->user->name }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $order->created_at->format('M j, Y') }}</td>
                            <td class="px-5 py-3 font-medium text-ink">${{ number_format($order->total, 2) }}</td>
                            <td class="px-5 py-3"><x-status-badge :status="$order->status" /></td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-brand-600 hover:text-brand-400">Manage</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-gray-500">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endsection
