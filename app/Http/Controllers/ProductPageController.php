<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['images', 'variations', 'brand', 'product_category'])->where('slug', $slug)->firstOrFail();
        return view('pages.public.product', compact('product'));
    }
}
