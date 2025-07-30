<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockBatch;
use App\Models\StockTransaction;

class StockTransactionController extends Controller
{
    public function create()
    {
        $batches = StockBatch::with('productVariation.product')->get();
        return view('pages.admin.add-stock-transaction', compact('batches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock_batch_id'   => 'required|exists:stock_batches,id',
            'transaction_type' => 'required|in:in,out',
            'quantity'         => 'required|integer|min:1',
            'transaction_date' => 'required|date',
            'remarks'          => 'nullable|string|max:255',
        ]);

        // Prevent OUT if insufficient stock
        if ($validated['transaction_type'] === 'out') {
            $batch = \App\Models\StockBatch::find($validated['stock_batch_id']);
            if (!$batch || $batch->quantity < $validated['quantity']) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['quantity' => 'Insufficient stock in this batch for OUT transaction.']);
            }
        }

        StockTransaction::create($validated);

        return redirect()->back()->with('success', 'Stock transaction recorded and product stock updated.');
    }

    public function index(Request $request)
    {
        $query = StockTransaction::with(['stockBatch.productVariation.product']);

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->input('type'));
        }
        if ($request->filled('batch')) {
            $query->where('stock_batch_id', $request->input('batch'));
        }
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->input('date_to'));
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(15);

        $batches = \App\Models\StockBatch::with('productVariation.product')->get();

        return view('pages.admin.view-stock-transactions', compact('transactions', 'batches'));
    }
}
