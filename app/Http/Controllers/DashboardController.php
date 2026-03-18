<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->is_admin) {
            $stats = [
                'users' => \App\Models\User::count(),
                'products' => Product::count(),
                'categories' => Category::count(),
                'orders' => Order::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
            ];

            $orders = Order::with(['user', 'product'])
                ->latest()
                ->take(10)
                ->get();

            return view('dashboard', [
                'isAdmin' => true,
                'stats' => $stats,
                'orders' => $orders,
                'products' => Product::with('category')->latest()->take(8)->get(),
            ]);
        }

        $orders = Order::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('dashboard', [
            'isAdmin' => false,
            'orders' => $orders,
            'products' => Product::with('category')->latest()->take(8)->get(),
        ]);
    }
}
