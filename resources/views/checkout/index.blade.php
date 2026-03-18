@extends('layout')

@section('title', 'Checkout')

@section('content')
    <h1 style="font-size: 28px; margin-bottom: 18px;">Checkout</h1>

    <div class="grid grid-2">
        <div class="card" style="overflow-x:auto;">
            <h3 style="margin-top:0;">Order Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'] * $item['quantity'], 2) }} EGP</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p style="margin:14px 0 0;color:#6b7280;">Items: {{ $itemsCount }}</p>
            <p style="margin:4px 0 0;font-size:22px;font-weight:bold;">Grand Total: {{ number_format($subtotal, 2) }} EGP</p>
            <p style="margin:8px 0 0;color:#047857;font-weight:bold;">Payment Method: Cash On Delivery</p>
        </div>

        <div class="card">
            <h3 style="margin-top:0;">Shipping Address</h3>

            @if($errors->any())
                <div style="margin-bottom:12px;color:#b91c1c;">
                    <ul style="margin:0;padding-left:16px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('checkout.store') }}" style="display:grid;gap:12px;">
                @csrf
                <div>
                    <label style="display:block;margin-bottom:4px;font-weight:bold;">Full Name</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;">
                </div>

                <div>
                    <label style="display:block;margin-bottom:4px;font-weight:bold;">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;">
                </div>

                <div>
                    <label style="display:block;margin-bottom:4px;font-weight:bold;">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" required style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;">
                </div>

                <div>
                    <label style="display:block;margin-bottom:4px;font-weight:bold;">Address</label>
                    <textarea name="address" rows="3" required style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label style="display:block;margin-bottom:4px;font-weight:bold;">Notes (optional)</label>
                    <textarea name="notes" rows="2" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:6px;">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" style="padding:10px 14px;border:none;background:#16a34a;color:#fff;border-radius:8px;cursor:pointer;font-weight:bold;">Place Order (Cash)</button>
            </form>
        </div>
    </div>
@endsection
