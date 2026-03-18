<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['user', 'product'])
            ->latest()
            ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Order status updated successfully.');
    }
}
