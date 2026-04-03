@extends('layouts.admin')

@section('content')

<div class="p-6">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Products</h1>

        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Product
        </a>
    </div>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Image</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        @foreach($products as $product)
            <tr class="border-t">
                <td class="p-3">
                    <img src="{{ $product->getFirstMediaUrl('product_images') }}"
                         class="w-12 h-12 object-cover rounded">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->type }}</td>
                <td>{{ $product->price }}</td>

                <td class="flex gap-2">
                    <a href="{{ route('admin.products.edit',$product->id) }}"
                       class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>

                    <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="bg-red-600 text-white px-2 py-1 rounded">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection