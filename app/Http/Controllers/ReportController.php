<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\StockBatch;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function all_reports() {
        return view('pages.admin.reports');
    }

    public function stock_level_report() {
        $allBrands = Brand::where('status', 'active')->get();
        return view('pages.admin.report-stock-level', compact('allBrands'));
    }
    
    public function stock_level(Request $request) {
        $reportFilter = $request->all();
        $errMsg = "";
        $reportData = "";
        if (!$request->has('brand')) {
            $errMsg = "Please select brand/s or ALL.";
        } else {
            if ($request->brand[0] === "all") {
                $reportData = Product::all();
            } else {
                $reportData = Product::whereIn('brand_id', $request->brand)->with(['variations'])->get();
            }
        } 
        return view('pages.admin.report-print-previews.stock-level-report', compact('errMsg', 'reportData'));
    }

    public function stock_movement_report(Request $request)
    {
        $allBrands = Brand::all();
        return view('pages.admin.report-stock-movement', compact('allBrands'));
    }

    public function stock_movement(Request $request)
    {
        $brandIds = $request->input('brand', []);
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = StockTransaction::with(['stockBatch.productVariation.product.brand']);

        if ($brandIds && !in_array('all', $brandIds)) {
            $query->whereHas('stockBatch.productVariation.product', function ($q) use ($brandIds) {
                $q->whereIn('brand_id', $brandIds);
            });
        }
        if ($dateFrom) {
            $query->whereDate('transaction_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('transaction_date', '<=', $dateTo);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();

        return view('pages.admin.report-print-previews.stock-movement', compact('transactions', 'dateFrom', 'dateTo'));
    }

    public function low_stock_report()
    {
        // Get all products with at least one variation that is low stock
        $products = Product::with(['variations' => function($q) {
            $q->with(['batch']);
        }])->get();

        $lowStockData = [];

        foreach ($products as $product) {
            $lowVariations = [];
            foreach ($product->variations as $variation) {
                // Get all batches for this variation
                $batches = $variation->batch;
                // Sum all IN transactions for this variation's batches
                $maxIn = StockTransaction::whereIn('stock_batch_id', $batches->pluck('id'))
                    ->where('transaction_type', 'in')
                    ->sum('quantity');
                // Current stock
                $currentStock = $variation->stock;
                // If maxIn is 0, skip
                if ($maxIn > 0 && $currentStock <= ($maxIn * 0.1)) {
                    $lowVariations[] = [
                        'name' => $variation->name,
                        'sku' => $variation->sku,
                        'unit' => $variation->unit ?? '',
                        'stock' => $currentStock,
                        'max_in' => $maxIn,
                    ];
                }
            }
            if (count($lowVariations)) {
                $lowStockData[] = [
                    'product' => $product,
                    'variations' => $lowVariations,
                ];
            }
        }

        return view('pages.admin.report-low-stock', [
            'lowStockData' => $lowStockData,
        ]);
    }

    public function low_stock_print()
    {
        // Same logic as above, but for print preview
        $products = Product::with(['variations' => function($q) {
            $q->with(['batch']);
        }])->get();

        $lowStockData = [];

        foreach ($products as $product) {
            $lowVariations = [];
            foreach ($product->variations as $variation) {
                $batches = $variation->batch;
                $maxIn = StockTransaction::whereIn('stock_batch_id', $batches->pluck('id'))
                    ->where('transaction_type', 'in')
                    ->sum('quantity');
                $currentStock = $variation->stock;
                if ($maxIn > 0 && $currentStock <= ($maxIn * 0.1)) {
                    $lowVariations[] = [
                        'name' => $variation->name,
                        'sku' => $variation->sku,
                        'unit' => $variation->unit ?? '',
                        'stock' => $currentStock,
                        'max_in' => $maxIn,
                    ];
                }
            }
            if (count($lowVariations)) {
                $lowStockData[] = [
                    'product' => $product,
                    'variations' => $lowVariations,
                ];
            }
        }

        return view('pages.admin.report-print-previews.low-stock', [
            'lowStockData' => $lowStockData,
        ]);
    }
}
