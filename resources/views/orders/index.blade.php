@extends('layout')

@section('title', 'Orders Management')

@section('content')
    <h1 style="font-size: 28px; margin-bottom: 18px;">Orders Management</h1>

    <div style="overflow-x:auto;" class="card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order No.</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Address</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Ordered At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_number ?? ('ORD-' . $order->id) }}</td>
                        <td>{{ $order->user->name }}<br><span style="font-size:12px;color:#6b7280;">{{ $order->user->email }}</span></td>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->city }}<br><span style="font-size:12px;color:#6b7280;">{{ $order->address }}</span></td>
                        <td>{{ ucfirst($order->payment_method ?? 'cash') }}</td>
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
                                <form method="POST" action="{{ route('orders.update-status', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="pending">
                                    <button class="btn btn-pending">Pending</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center;color:#6b7280;">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 12px;">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
