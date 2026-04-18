<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
   public function index(Request $request)
{
    $query = Product::where('status', 1);

    // 🔥 type filter (hen / egg)
    if ($request->type) {
        $query->where('type', $request->type);
    }

    $products = $query->latest()->get();

    return view('custom.shop', compact('products'));
}

   public function show($slug)
{
    $product = Product::with('category')->where('slug', $slug)->firstOrFail();

    $relatedProducts = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('status', 1)
        ->latest()
        ->take(4)
        ->get();

    return view('custom.shop-detail', compact('product', 'relatedProducts'));
}
}