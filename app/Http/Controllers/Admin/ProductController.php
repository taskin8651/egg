<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');

        return view('admin.products.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'type' => 'required|in:egg,hen',
            'price' => 'required|numeric',
            'min_order_qty' => 'required|integer|min:1',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . time()),
            'category_id' => $request->category_id,
            'type' => $request->type,
            'price' => $request->price,
            'bulk_price' => $request->bulk_price,
            'min_order_qty' => $request->min_order_qty,
            'stock' => $request->stock,
            'description' => $request->description,
            'status' => 1,
        ]);

        // 🔥 Tags attach
        $product->tags()->sync($request->tags);

        // 🔥 Image upload
        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')
                    ->toMediaCollection('product_images');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product Created');
    }

    public function edit(Product $product)
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');

        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'type' => 'required|in:egg,hen',
            'price' => 'required|numeric',
            'min_order_qty' => 'required|integer|min:1',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . time()),
            'category_id' => $request->category_id,
            'type' => $request->type,
            'price' => $request->price,
            'bulk_price' => $request->bulk_price,
            'min_order_qty' => $request->min_order_qty,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        $product->tags()->sync($request->tags);

        if ($request->hasFile('image')) {
            $product->clearMediaCollection('product_images');

            $product->addMediaFromRequest('image')
                    ->toMediaCollection('product_images');
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product Updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Deleted');
    }
}