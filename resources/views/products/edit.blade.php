@extends('layout')

@section('title', 'Edit Product')

@section('content')
    <h1 style="margin-bottom: 16px;">Edit Product</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name', $product->name) }}"><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"><br><br>

        <label>Stock Quantity:</label><br>
        <input type="number" step="1" min="0" name="stock" value="{{ old('stock', $product->stock) }}"><br><br>

        <label>Category:</label><br>
        <select name="category_id">
            <option value="">-- Select Category --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Current Image:</label><br>
        <img src="{{ asset('storage/' . $product->image) }}" width="100"><br><br>

        <label>Change Image (optional):</label><br>
        <input type="file" name="image"><br><br>

        <button type="submit">Update Product</button>
    </form>
@endsection
