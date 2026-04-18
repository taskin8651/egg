@extends('layouts.admin')
@section('content')

<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Add Product</h1>
        <p class="text-sm text-gray-500 mt-1">Create new product (Egg / Hen)</p>
    </div>

    <a href="{{ route('admin.products.index') }}"
       class="text-sm text-blue-600 hover:underline">
        ← Back
    </a>
</div>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.products.store') }}">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- PRODUCT INFO --}}
    <div class="bg-white border rounded-lg shadow-sm p-6">

        <h2 class="text-sm font-semibold mb-4 uppercase">Product Info</h2>

        {{-- NAME --}}
        <div class="mb-4">
            <label>Name *</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded-md p-2">
            @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
        </div>

        {{-- CATEGORY --}}
        <div class="mb-4">
            <label>Category</label>
            <select name="category_id" class="w-full border p-2 rounded">
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        {{-- TYPE --}}
        <div class="mb-4">
            <label>Type</label>
            <select name="type" class="w-full border p-2 rounded">
                <option value="egg">Egg</option>
                <option value="hen">Hen</option>
            </select>
        </div>

        {{-- PRICE --}}
        <div class="mb-4">
            <label>Price</label>
            <input type="number" name="price" step="0.01"
                   class="w-full border p-2 rounded">
        </div>

        {{-- BULK PRICE --}}
        <div>
            <label>Bulk Price</label>
            <input type="number" name="bulk_price" step="0.01"
                   class="w-full border p-2 rounded">
        </div>

    </div>

    {{-- EXTRA INFO --}}
    <div class="bg-white border rounded-lg shadow-sm p-6">

        <h2 class="text-sm font-semibold mb-4 uppercase">Additional Info</h2>

        {{-- MIN QTY --}}
        <div class="mb-4">
            <label>Min Order Qty</label>
            <input type="number" name="min_order_qty"
                   class="w-full border p-2 rounded">
        </div>

        {{-- STOCK --}}
        <div class="mb-4">
            <label>Stock</label>
            <input type="number" name="stock"
                   class="w-full border p-2 rounded">
        </div>

        {{-- 🔥 THUMBNAIL --}}
        <div class="mb-4">
            <label>Thumbnail (Main Image)</label>
            <input type="file" name="thumbnail" class="w-full border p-2 rounded">
        </div>

        {{-- 🔥 GALLERY --}}
        <div class="mb-4">
            <label>Gallery Images (Multiple)</label>
            <input type="file" name="gallery[]" multiple
                   class="w-full border p-2 rounded">
        </div>

        {{-- TAGS --}}
        <div>
            <div class="flex justify-between mb-2">
                <label>Tags</label>

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
                               class="tag-checkbox">
                        {{ $tag }}
                    </label>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- DESCRIPTION --}}
<div class="mt-6 bg-white border rounded-lg shadow-sm p-6">
    <label>Description</label>
    <textarea name="description" class="w-full border p-2 rounded"></textarea>
</div>

{{-- BUTTON --}}
<div class="mt-6 flex gap-3">
    <button class="bg-blue-600 text-white px-6 py-2 rounded">
        Save Product
    </button>

    <a href="{{ route('admin.products.index') }}" class="text-gray-600">
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