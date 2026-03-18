@extends('layout')

@section('title', 'Product Details')

@section('content')
    @php
        $imageSrc = str_starts_with($product->image, 'http')
            ? $product->image
            : asset('storage/' . $product->image);
    @endphp

    <div style="padding: 24px; max-width: 720px; margin: auto;">
        <a href="{{ route('products.index') }}" style="text-decoration: none; color: #007185;">&larr; Back to Products</a>

        <div style="margin-top: 16px; border: 1px solid #ddd; border-radius: 10px; padding: 20px; background: #fff;">
            <div style="width: 100%; height: 280px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f7f7f7; border-radius: 8px;">
                <img src="{{ $imageSrc }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>

            <h1 style="margin-top: 16px; margin-bottom: 6px;">{{ $product->name }}</h1>
            <p style="margin: 0; color: #666;">Category: {{ $product->category->name }}</p>
            <p style="font-size: 22px; font-weight: bold; color: #b12704; margin-top: 8px;">{{ number_format($product->price, 2) }} EGP</p>
            <p style="margin: 0; color: {{ $product->stock > 0 ? '#047857' : '#b91c1c' }}; font-weight: bold;">Available Stock: {{ $product->stock }}</p>

            @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-top: 16px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(auth()->user()?->is_admin)
                <div style="margin-top: 20px; display: flex; gap: 12px;">
                    <a href="{{ route('products.edit', $product) }}" style="padding: 10px 14px; background: #0b74de; color: #fff; text-decoration: none; border-radius: 6px;">Edit Product</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure you want to delete this product?')" style="padding: 10px 14px; border: none; background: #d11a2a; color: #fff; border-radius: 6px; cursor: pointer;">Delete Product</button>
                    </form>
                </div>
            @else
                <form method="POST" action="{{ route('cart.add', $product) }}" style="margin-top: 20px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    @csrf
                    <label for="quantity" style="font-weight: bold;">Quantity</label>
                    <input id="quantity" name="quantity" type="number" min="1" max="{{ max($product->stock, 1) }}" value="1" {{ $product->stock < 1 ? 'disabled' : '' }} required style="width: 90px; padding: 8px; border: 1px solid #ccc; border-radius: 6px;">
                    <button type="submit" {{ $product->stock < 1 ? 'disabled' : '' }} style="padding: 10px 14px; border: none; background: {{ $product->stock > 0 ? '#2563eb' : '#9ca3af' }}; color: #fff; border-radius: 6px; cursor: {{ $product->stock > 0 ? 'pointer' : 'not-allowed' }}; font-weight: bold;">{{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}</button>
                </form>

                @error('quantity')
                    <p style="color: #c62828; margin-top: 8px;">{{ $message }}</p>
                @enderror
            @endif
        </div>
    </div>
@endsection
