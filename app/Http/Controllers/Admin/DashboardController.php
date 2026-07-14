<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $paidStatuses = ['paid', 'shipped', 'delivered'];

        $stats = [
            'total_orders' => Order::count(),
            'paid_orders' => Order::whereIn('status', $paidStatuses)->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'revenue' => (float) Order::whereIn('status', $paidStatuses)->sum('total'),
            'customers' => User::where('role', 'customer')->count(),
            'books' => Book::count(),
        ];

        $lowStock = Book::where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(10)
            ->get();

        $recentOrders = Order::with('user')->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'lowStock', 'recentOrders'));
    }
}
