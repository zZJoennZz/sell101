<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StockBatch;
use App\Models\ProductVariation;

class StockBatchController extends Controller
{
    public function index(Request $request)
    {
        $query = StockBatch::with('productVariation.product');

        if ($request->filled('product_variation_id')) {
            $query->where('product_variation_id', $request->input('product_variation_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $batches = $query->orderBy('created_at', 'desc')->paginate(15);
        $variations = ProductVariation::with('product')->get();

        return view('pages.admin.view-stock-batches', compact('batches', 'variations'));
    }

    public function create()
    {
        $products = Product::all();
        $variations = ProductVariation::with('product')->get();
        return view('pages.admin.add-stock-batch', compact('products', 'variations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_variation_id' => 'required|exists:product_variations,id',
            'batch_number'         => 'required|string|max:255',
            'has_expiry'           => 'required|boolean',
            'manufacture_date'     => 'nullable|date',
            'expiry_date'          => 'nullable|date|after_or_equal:manufacture_date',
            'status'               => 'required|in:active,inactive',
        ]);

        $validated['quantity'] = 0; // Always start at 0

        StockBatch::create($validated);

        return redirect()->route('admin.stockbatches')->with('success', 'Stock batch added successfully!');
    }

    public function edit($id)
    {
        $batch = StockBatch::findOrFail($id);
        $products = Product::all();
        $variations = ProductVariation::with('product')->get();
        return view('pages.admin.edit-stock-batch', compact('batch', 'products', 'variations'));
    }

    public function update(Request $request, $id)
    {
        $batch = StockBatch::findOrFail($id);

        $validated = $request->validate([
            'product_variation_id' => 'required|exists:product_variations,id',
            'batch_number'         => 'required|string|max:255',
            'has_expiry'           => 'required|boolean',
            'manufacture_date'     => 'nullable|date',
            'expiry_date'          => 'nullable|date|after_or_equal:manufacture_date',
            'status'               => 'required|in:active,inactive',
        ]);

        // Do not update quantity here
        $batch->update($validated);

        return redirect()->route('admin.stockbatches')->with('success', 'Stock batch updated successfully!');
    }
}
