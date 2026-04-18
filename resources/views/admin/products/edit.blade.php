@extends('layouts.admin')
@section('content')

<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Product</h1>
        <p class="text-sm text-gray-500 mt-1">Update product</p>
    </div>

    <a href="{{ route('admin.products.index') }}"
       class="text-sm text-blue-600 hover:underline">
        ← Back
    </a>
</div>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('admin.products.update', $product->id) }}">
@csrf
@method('PUT')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- LEFT --}}
    <div class="bg-white border rounded-lg shadow-sm p-6">

        <h2 class="font-semibold mb-4">Product Info</h2>

        <input type="text" name="name"
               value="{{ old('name', $product->name) }}"
               class="w-full border p-2 mb-3 rounded"
               placeholder="Name">

        <select name="category_id" class="w-full border p-2 mb-3 rounded">
            @foreach($categories as $id => $name)
                <option value="{{ $id }}"
                    {{ $product->category_id == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>

        <select name="type" class="w-full border p-2 mb-3 rounded">
            <option value="egg" {{ $product->type=='egg'?'selected':'' }}>Egg</option>
            <option value="hen" {{ $product->type=='hen'?'selected':'' }}>Hen</option>
        </select>

        <input type="number" name="price"
               value="{{ $product->price }}"
               class="w-full border p-2 mb-3 rounded"
               placeholder="Price">

        <input type="number" name="bulk_price"
               value="{{ $product->bulk_price }}"
               class="w-full border p-2 rounded"
               placeholder="Bulk Price">

    </div>

    {{-- RIGHT --}}
    <div class="bg-white border rounded-lg shadow-sm p-6">

        <h2 class="font-semibold mb-4">Extra Info</h2>

        <input type="number" name="min_order_qty"
               value="{{ $product->min_order_qty }}"
               class="w-full border p-2 mb-3 rounded"
               placeholder="Min Qty">

        <input type="number" name="stock"
               value="{{ $product->stock }}"
               class="w-full border p-2 mb-4 rounded"
               placeholder="Stock">

        {{-- 🔥 THUMBNAIL --}}
        <div class="mb-4">
            <label class="font-medium">Thumbnail</label>

            @if($product->getFirstMediaUrl('product_thumbnail'))
                <div class="relative inline-block mb-2">
                    <img src="{{ $product->getFirstMediaUrl('product_thumbnail') }}"
                         class="w-24 h-24 object-cover rounded border">

                    <button type="button"
                            onclick="deleteMedia({{ optional($product->getFirstMedia('product_thumbnail'))->id }})"
                            class="absolute top-0 right-0 bg-red-600 text-white px-2 text-xs rounded">
                        ×
                    </button>
                </div>
            @endif

            <input type="file" name="thumbnail" class="w-full border p-2 rounded">
        </div>

        {{-- 🔥 GALLERY --}}
        <div class="mb-4">
            <label class="font-medium">Gallery Images</label>

            <div class="flex flex-wrap gap-3 mb-3">
                @foreach($product->getMedia('product_gallery') as $media)
                    <div class="relative">
                        <img src="{{ $media->getUrl() }}"
                             class="w-20 h-20 object-cover rounded border">

                        <button type="button"
                                onclick="deleteMedia({{ $media->id }})"
                                class="absolute top-0 right-0 bg-red-600 text-white px-2 text-xs rounded">
                            ×
                        </button>
                    </div>
                @endforeach
            </div>

            <input type="file" name="gallery[]" multiple class="w-full border p-2 rounded">
        </div>

        {{-- TAGS --}}
        <div>
            <label class="font-medium">Tags</label>

            <div class="grid grid-cols-2 gap-2 mt-2">
                @foreach($tags as $id => $tag)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox"
                               name="tags[]"
                               value="{{ $id }}"
                               {{ $product->tags->pluck('id')->contains($id) ? 'checked' : '' }}>
                        {{ $tag }}
                    </label>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- DESCRIPTION --}}
<div class="mt-6 bg-white border rounded-lg p-6">
    <textarea name="description"
              class="w-full border p-2 rounded"
              placeholder="Description">{{ $product->description }}</textarea>
</div>

<div class="mt-6">
    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">
        Update Product
    </button>
</div>

</form>

{{-- 🔥 DELETE SCRIPT --}}
<script>
function deleteMedia(id) {
    if(confirm('Delete this image?')) {

        fetch("{{ route('admin.products.deleteMedia') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ media_id: id })
        })
        .then(res => res.json())
        .then(() => location.reload())
        .catch(() => alert('Delete failed'));

    }
}
</script>

@endsection