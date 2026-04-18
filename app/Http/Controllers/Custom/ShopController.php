<?php

namespace App\Http\Controllers\Custom;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->where('status', 1)->latest()->get();

        return view('custom.shop', compact('products'));
    }

    public function show($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();

    return view('custom.product-details', compact('product'));
}
}