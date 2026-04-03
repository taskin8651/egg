@extends('layouts.admin')

@section('content')

<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Product</h1>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ route('admin.products.update', $product->id) }}"
          class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label class="block mb-1 font-medium">Product Name</label>
            <input type="text" name="name"
                   value="{{ $product->name }}"
                   class="w-full border rounded-lg p-2">

            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category -->
        <div>
            <label class="block mb-1 font-medium">Category</label>
            <select name="category_id" class="w-full border rounded-lg p-2">
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}"
                        {{ $product->category_id == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Type -->
        <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type" class="w-full border rounded-lg p-2">
                <option value="egg" {{ $product->type == 'egg' ? 'selected' : '' }}>Egg</option>
                <option value="hen" {{ $product->type == 'hen' ? 'selected' : '' }}>Hen</option>
            </select>
        </div>

        <!-- Price -->
        <div>
            <label class="block mb-1 font-medium">Price</label>
            <input type="text" name="price"
                   value="{{ $product->price }}"
                   class="w-full border rounded-lg p-2">
        </div>

        <!-- Bulk Price -->
        <div>
            <label class="block mb-1 font-medium">Bulk Price</label>
            <input type="text" name="bulk_price"
                   value="{{ $product->bulk_price }}"
                   class="w-full border rounded-lg p-2">
        </div>

        <!-- Min Qty -->
        <div>
            <label class="block mb-1 font-medium">Minimum Order Quantity</label>
            <input type="number" name="min_order_qty"
                   value="{{ $product->min_order_qty }}"
                   class="w-full border rounded-lg p-2">
        </div>

        <!-- Stock -->
        <div>
            <label class="block mb-1 font-medium">Stock</label>
            <input type="number" name="stock"
                   value="{{ $product->stock }}"
                   class="w-full border rounded-lg p-2">
        </div>

        <!-- Image Preview -->
        <div>
            <label class="block mb-1 font-medium">Current Image</label>

            @if($product->getFirstMediaUrl('product_images'))
                <img src="{{ $product->getFirstMediaUrl('product_images') }}"
                     class="w-24 h-24 object-cover rounded mb-2">
            @endif

            <input type="file" name="image" class="w-full">
        </div>

        <!-- Tags -->
        <div>
            <label class="block mb-1 font-medium">Tags</label>
            <select name="tags[]" multiple class="w-full border rounded-lg p-2">

                @foreach($tags as $id => $name)
                    <option value="{{ $id }}"
                        {{ $product->tags->contains($id) ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach

            </select>
        </div>

        <!-- Description -->
        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description"
                      class="w-full border rounded-lg p-2">{{ $product->description }}</textarea>
        </div>

        <!-- Submit -->
        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Update Product
        </button>

    </form>
</div>

@endsection