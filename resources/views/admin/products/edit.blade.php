@extends('layouts.admin')
@section('content')

{{-- HEADER --}}
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">
            Edit Product
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Update product details
        </p>
    </div>

    <a href="{{ route('admin.products.index') }}"
       class="text-sm text-blue-600 hover:underline">
        ← Back to list
    </a>
</div>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.products.update', $product->id) }}">
@csrf
@method('PUT')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- PRODUCT INFO --}}
    <div class="bg-white border rounded-lg shadow-sm p-6">

        <h2 class="text-sm font-semibold text-gray-700 mb-4 uppercase">
            Product Info
        </h2>

        {{-- NAME --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Name *</label>

            <input type="text" name="name"
                   value="{{ old('name', $product->name) }}"
                   class="w-full border rounded-md p-2">

            @error('name')
                <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror
        </div>

        {{-- CATEGORY --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Category</label>

            <select name="category_id" class="w-full border rounded-md p-2">
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}"
                        {{ old('category_id', $product->category_id) == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TYPE --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Type</label>

            <select name="type" class="w-full border rounded-md p-2">
                <option value="egg" {{ $product->type == 'egg' ? 'selected' : '' }}>Egg</option>
                <option value="hen" {{ $product->type == 'hen' ? 'selected' : '' }}>Hen</option>
            </select>
        </div>

        {{-- PRICE --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Price</label>
            <input type="text" name="price"
                   value="{{ old('price', $product->price) }}"
                   class="w-full border rounded-md p-2">
        </div>

        {{-- BULK PRICE --}}
        <div>
            <label class="block text-sm font-medium mb-1">Bulk Price</label>
            <input type="text" name="bulk_price"
                   value="{{ old('bulk_price', $product->bulk_price) }}"
                   class="w-full border rounded-md p-2">
        </div>

    </div>

    {{-- EXTRA INFO --}}
    <div class="bg-white border rounded-lg shadow-sm p-6">

        <h2 class="text-sm font-semibold text-gray-700 mb-4 uppercase">
            Additional Info
        </h2>

        {{-- MIN QTY --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Min Order Qty</label>
            <input type="number" name="min_order_qty"
                   value="{{ old('min_order_qty', $product->min_order_qty) }}"
                   class="w-full border p-2 rounded-md">
        </div>

        {{-- STOCK --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Stock</label>
            <input type="number" name="stock"
                   value="{{ old('stock', $product->stock) }}"
                   class="w-full border p-2 rounded-md">
        </div>

        {{-- IMAGE --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Current Image</label>

            @if($product->getFirstMediaUrl('product_images'))
                <img src="{{ $product->getFirstMediaUrl('product_images') }}"
                     class="w-24 h-24 object-cover rounded mb-2">
            @endif

            <input type="file" name="image" class="w-full">
        </div>

        {{-- TAGS --}}
        <div>
            <div class="flex justify-between mb-2">
                <label class="text-sm font-medium">Tags</label>

                <div class="text-xs space-x-2">
                    <button type="button" id="select-all" class="text-blue-600">Select All</button>
                    <button type="button" id="deselect-all" class="text-blue-600">Deselect</button>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto">
                @foreach($tags as $id => $tag)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox"
                               name="tags[]"
                               value="{{ $id }}"
                               class="tag-checkbox"
                               {{ $product->tags->contains($id) ? 'checked' : '' }}>
                        {{ $tag }}
                    </label>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- DESCRIPTION --}}
<div class="mt-6 bg-white border rounded-lg shadow-sm p-6">
    <label class="block text-sm font-medium mb-2">Description</label>
    <textarea name="description"
              class="w-full border rounded-md p-2">{{ old('description', $product->description) }}</textarea>
</div>

{{-- BUTTON --}}
<div class="mt-6 flex gap-3">
    <button class="bg-green-600 text-white px-6 py-2 rounded-md">
        Update Product
    </button>

    <a href="{{ route('admin.products.index') }}"
       class="text-gray-600 hover:underline">
        Cancel
    </a>
</div>

</form>

@endsection

@section('scripts')
<script>
document.getElementById('select-all').onclick = () => {
    document.querySelectorAll('.tag-checkbox').forEach(cb => cb.checked = true);
}

document.getElementById('deselect-all').onclick = () => {
    document.querySelectorAll('.tag-checkbox').forEach(cb => cb.checked = false);
}
</script>
@endsection