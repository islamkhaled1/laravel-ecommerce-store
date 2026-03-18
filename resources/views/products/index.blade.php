@extends('layout')

@section('title', 'Products')

@section('content')
    <div style="max-width: 1200px; margin: auto; padding: 30px;">
        <h1 style="font-size: 26px; margin-bottom: 20px;">Products</h1>

          @if(auth()->user()?->is_admin)
                <a href="{{ route('products.create') }}"
                    style="padding: 10px 20px; background-color: #ffa41c; color: #111; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    + Add New Product
                </a>
          @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
            @forelse($products as $product)
                <div style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background: #fff; box-shadow: 0 0 5px rgba(0,0,0,0.1); text-align: center;">
                    @php
                        $imageSrc = str_starts_with($product->image, 'http')
                            ? $product->image
                            : asset('storage/' . $product->image);
                    @endphp
                    
                    <div style="width: 100%; height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f7f7f7; margin-bottom: 10px;">
                        <img src="{{ $imageSrc }}"
                             alt="{{ $product->name }}"
                             style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>

                    <h2 style="font-size: 18px; color: #333; margin-bottom: 5px;">{{ $product->name }}</h2>
                    <p style="color: #b12704; font-size: 16px; font-weight: bold;">{{ number_format($product->price, 2) }} EGP</p>
                    <p style="font-size: 14px; color: #555;">Category: {{ $product->category->name }}</p>
                    <p style="font-size: 14px; color: {{ $product->stock > 0 ? '#047857' : '#b91c1c' }}; font-weight: bold;">Stock: {{ $product->stock }}</p>

                    <div style="margin-top: 10px; display: flex; justify-content: center; gap: 12px; align-items: center;">
                        <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: #007185;">View</a>

                        @if(auth()->user()?->is_admin)
                            <a href="{{ route('products.edit', $product->id) }}" style="text-decoration: none; color: #007185;">Edit</a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                    style="background: none; color: red; border: none; cursor: pointer;">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p>No products found.</p>
            @endforelse
        </div>
    </div>
@endsection
