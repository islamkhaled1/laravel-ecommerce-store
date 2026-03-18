@extends('layout')

@section('title', 'My Cart')

@section('content')
    <h1 style="font-size: 28px; margin-bottom: 18px;">My Cart</h1>

    @if(empty($cart))
        <div class="card">
            <p style="margin: 0 0 12px; color:#6b7280;">Your cart is empty.</p>
            <a href="{{ route('products.index') }}" style="text-decoration:none;color:#2563eb;font-weight:bold;">Browse products</a>
        </div>
    @else
        <div class="card" style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        @php
                            $imageSrc = str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/' . $item['image']);
                            $lineTotal = $item['price'] * $item['quantity'];
                            $availableStock = (int)($item['stock'] ?? 0);
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <img src="{{ $imageSrc }}" alt="{{ $item['name'] }}" style="width:58px;height:58px;object-fit:contain;border:1px solid #eee;border-radius:6px;background:#fff;">
                                    <div>
                                        <div>{{ $item['name'] }}</div>
                                        <div style="font-size:12px;color:#6b7280;">Available: {{ $availableStock }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($item['price'], 2) }} EGP</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update', $item['product_id']) }}" style="display:flex;gap:8px;align-items:center;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" min="1" max="{{ max($availableStock, 1) }}" value="{{ $item['quantity'] }}" style="width:70px;padding:6px;border:1px solid #ccc;border-radius:6px;">
                                    <button type="submit" style="padding:6px 10px;border:none;background:#2563eb;color:#fff;border-radius:6px;cursor:pointer;">Update</button>
                                </form>
                            </td>
                            <td>{{ number_format($lineTotal, 2) }} EGP</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', $item['product_id']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding:6px 10px;border:none;background:#dc2626;color:#fff;border-radius:6px;cursor:pointer;">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card" style="margin-top: 14px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
            <div>
                <p style="margin:0;color:#6b7280;">Items: {{ $itemsCount }}</p>
                <p style="margin:4px 0 0;font-size:22px;font-weight:bold;color:#111827;">Subtotal: {{ number_format($subtotal, 2) }} EGP</p>
            </div>
            <a href="{{ route('checkout.index') }}" style="text-decoration:none;background:#16a34a;color:#fff;padding:10px 14px;border-radius:8px;font-weight:bold;">Proceed to Checkout</a>
        </div>
    @endif
@endsection
