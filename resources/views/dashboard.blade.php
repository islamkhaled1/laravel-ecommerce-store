@extends('layout')

@section('title', $isAdmin ? 'Admin Dashboard' : 'My Dashboard')

@section('content')
    <h1 style="font-size: 28px; margin-bottom: 18px;">
        @if($isAdmin)
            Admin Dashboard
        @else
            My Dashboard
        @endif
    </h1>

    @if($isAdmin)
        <div class="grid grid-5" style="margin-bottom: 22px;">
            <div class="card">
                <p style="margin:0;color:#6b7280;">Users</p>
                <p style="margin:6px 0 0;font-size:28px;font-weight:bold;">{{ $stats['users'] }}</p>
            </div>
            <div class="card">
                <p style="margin:0;color:#6b7280;">Products</p>
                <p style="margin:6px 0 0;font-size:28px;font-weight:bold;">{{ $stats['products'] }}</p>
            </div>
            <div class="card">
                <p style="margin:0;color:#6b7280;">Categories</p>
                <p style="margin:6px 0 0;font-size:28px;font-weight:bold;">{{ $stats['categories'] }}</p>
            </div>
            <div class="card">
                <p style="margin:0;color:#6b7280;">All Orders</p>
                <p style="margin:6px 0 0;font-size:28px;font-weight:bold;">{{ $stats['orders'] }}</p>
            </div>
            <div class="card">
                <p style="margin:0;color:#6b7280;">Pending Orders</p>
                <p style="margin:6px 0 0;font-size:28px;font-weight:bold;color:#b45309;">{{ $stats['pending_orders'] }}</p>
            </div>
        </div>

        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:12px;">
                <h3 style="margin:0;font-size:20px;">Recent Orders</h3>
                <div style="display:flex;gap:12px;flex-wrap:wrap;">
                    <a href="{{ route('products.index') }}" style="color:#2563eb;text-decoration:none;font-weight:bold;">Manage products</a>
                    <a href="{{ route('orders.index') }}" style="color:#2563eb;text-decoration:none;font-weight:bold;">View all orders</a>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order No.</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_number ?? ('ORD-' . $order->id) }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td><span class="status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="actions">
                                        <form method="POST" action="{{ route('orders.update-status', $order) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button class="btn btn-approve">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('orders.update-status', $order) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="btn btn-reject">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" style="text-align:center;color:#6b7280;">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="grid grid-2">
            <div class="card">
                <h3 style="margin-top:0;">Available Products</h3>
                <p style="color:#6b7280;margin-top:0;">Order directly from the product details page.</p>

                <div style="display:grid;gap:10px;">
                    @forelse($products as $product)
                        <div style="display:flex;justify-content:space-between;align-items:center;border:1px solid #eee;border-radius:8px;padding:10px;gap:10px;">
                            <div>
                                <p style="margin:0;font-weight:bold;">{{ $product->name }}</p>
                                <p style="margin:4px 0 0;color:#6b7280;font-size:13px;">{{ $product->category->name }} • {{ number_format($product->price, 2) }} EGP</p>
                            </div>
                            <a href="{{ route('products.show', $product) }}" style="text-decoration:none;color:#2563eb;font-weight:bold;">Order</a>
                        </div>
                    @empty
                        <p style="color:#6b7280;">No products available right now.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h3 style="margin-top:0;">My Orders</h3>
                <div style="display:grid;gap:10px;">
                    @forelse($orders as $order)
                        <div style="border:1px solid #eee;border-radius:8px;padding:10px;">
                            <p style="margin:0 0 4px;color:#6b7280;font-size:12px;">Order #: {{ $order->order_number ?? ('ORD-' . $order->id) }}</p>
                            <p style="margin:0;font-weight:bold;">{{ $order->product->name }}</p>
                            <p style="margin:4px 0 0;color:#6b7280;font-size:13px;">Qty: {{ $order->quantity }} • {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            <span class="status {{ $order->status }}" style="margin-top:8px;">{{ ucfirst($order->status) }}</span>
                            <form method="POST" action="{{ route('orders.reorder', $order) }}" style="margin-top:8px;">
                                @csrf
                                <button type="submit" style="padding:6px 10px;border:none;background:#2563eb;color:#fff;border-radius:6px;cursor:pointer;font-size:12px;font-weight:bold;">Reorder</button>
                            </form>
                        </div>
                    @empty
                        <p style="color:#6b7280;">You have not placed any orders yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
@endsection
