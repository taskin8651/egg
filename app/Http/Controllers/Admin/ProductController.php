<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

        // ✅ Tags safe sync
        $product->tags()->sync($request->tags ?? []);

        // ✅ Thumbnail (single)
        if ($request->hasFile('thumbnail')) {
            $product->addMediaFromRequest('thumbnail')
                    ->toMediaCollection('product_thumbnail');
        }

        // ✅ Gallery (multiple)
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $product->addMedia($image)
                        ->toMediaCollection('product_gallery');
            }
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

    // ✅ Tags
    $product->tags()->sync($request->tags ?? []);

    // ✅ Thumbnail (replace)
    if ($request->hasFile('thumbnail')) {
        $product->clearMediaCollection('product_thumbnail');

        $product->addMediaFromRequest('thumbnail')
                ->toMediaCollection('product_thumbnail');
    }

    // ✅ Gallery (append only, NO delete)
    if ($request->hasFile('gallery')) {
        foreach ($request->file('gallery') as $image) {
            $product->addMedia($image)
                    ->toMediaCollection('product_gallery');
        }
    }

    return redirect()->route('admin.products.index')
        ->with('success', 'Product Updated Successfully');
}

    public function destroy(Product $product)
    {
        // ✅ media bhi delete hoga automatically
        $product->delete();

        return back()->with('success', 'Deleted');
    }

    public function deleteMedia(Request $request)
{
    Media::findOrFail($request->media_id)->delete();
    return back()->with('success', 'Image deleted');
}
}