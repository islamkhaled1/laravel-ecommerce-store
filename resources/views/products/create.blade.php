@extends('layout')

@section('title', 'Add Product')

@section('content')
    <div style="padding: 20px; max-width: 600px; margin: auto;">
        <h1 style="text-align: center; margin-bottom: 20px;">Add New Product</h1>

        @if($errors->any())
            <div style="color: red; margin-bottom: 20px;">
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
            @csrf

            <div>
                <label>Name:</label><br>
                <input type="text" name="name" value="{{ old('name') }}" required minlength="3" style="width: 100%; padding: 8px;">
            </div>

            <div>
                <label>Price (EGP):</label><br>
                <input type="number" name="price" step="0.01" min="0.01" value="{{ old('price') }}" required style="width: 100%; padding: 8px;">
            </div>

            <div>
                <label>Stock Quantity:</label><br>
                <input type="number" name="stock" min="0" step="1" value="{{ old('stock', 10) }}" required style="width: 100%; padding: 8px;">
            </div>

            <div>
                <label>Category:</label><br>
                <select name="category_id" required style="width: 100%; padding: 8px;">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Image:</label><br>
                <input type="file" name="image" required style="width: 100%; padding: 8px;">
            </div>

            <div style="text-align: center;">
                <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; font-weight: bold;">
                    Add Product
                </button>
            </div>
        </form>
    </div>
@endsection
