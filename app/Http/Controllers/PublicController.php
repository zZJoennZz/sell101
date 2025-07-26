<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    //

    public function home()
    {
        $products = Product::where('status', 'active')->limit(4)->get();
        return view('pages.public.home', compact('products'));
    }
}
