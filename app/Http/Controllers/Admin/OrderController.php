<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => Order::STATUSES,
            'activeStatus' => $status,
        ]);
    }

    public function show(Order $order)
    {
        $order->load('items.book', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(Order::STATUSES)],
        ]);

        if ($data['status'] === 'cancelled' && $order->status !== 'cancelled') {
            $order->load('items');
            foreach ($order->items as $item) {
                $item->book()->increment('stock', $item->quantity);
            }
        }

        $order->update(['status' => $data['status']]);

        return back()->with('success', "Order #{$order->id} marked as {$data['status']}.");
    }
}
