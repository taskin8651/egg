@extends('layouts.admin')

@section('content')

<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Add Product</h1>

    <form method="POST" enctype="multipart/form-data"
          action="{{ route('admin.products.store') }}"
          class="space-y-4">
        @csrf

        <input name="name" placeholder="Name" class="w-full border p-2">

        <select name="category_id" class="w-full border p-2">
            <option>Select Category</option>
            @foreach($categories as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <select name="type" class="w-full border p-2">
            <option value="egg">Egg</option>
            <option value="hen">Hen</option>
        </select>

        <input name="price" placeholder="Price" class="w-full border p-2">
        <input name="bulk_price" placeholder="Bulk Price" class="w-full border p-2">

        <input name="min_order_qty" placeholder="Min Order Qty" class="w-full border p-2">

        <input type="file" name="image" class="w-full">

        <select name="tags[]" multiple class="w-full border p-2">
            @foreach($tags as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <textarea name="description" class="w-full border p-2"></textarea>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Save
        </button>

    </form>
</div>

@endsection