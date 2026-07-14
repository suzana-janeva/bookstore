<?php

namespace App\Http\Controllers;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('items.book')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.book');

        return view('orders.show', compact('order'));
    }
}
