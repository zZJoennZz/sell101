<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockBatch;
use App\Models\StockTransaction;

class ProductDashboardController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $type = $request->input('transaction_type');

        // For chart and stats
        $transactionsQuery = StockTransaction::query()
            ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
            ->when($type, fn($q) => $q->where('transaction_type', $type));

        $transactionCount = $transactionsQuery->count();

        // Chart data (fix: do not double filter transaction_type)
        $days = collect();
        $inData = collect();
        $outData = collect();
        $start = \Carbon\Carbon::parse($dateFrom);
        $end = \Carbon\Carbon::parse($dateTo);
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $days->push($date->format('Y-m-d'));
            if ($type) {
                // Only show one type if filtered
                $inData->push(
                    $type == 'in'
                        ? StockTransaction::whereDate('transaction_date', $date->format('Y-m-d'))->where('transaction_type', 'in')->sum('quantity')
                        : 0
                );
                $outData->push(
                    $type == 'out'
                        ? StockTransaction::whereDate('transaction_date', $date->format('Y-m-d'))->where('transaction_type', 'out')->sum('quantity')
                        : 0
                );
            } else {
                $inData->push(StockTransaction::whereDate('transaction_date', $date->format('Y-m-d'))->where('transaction_type', 'in')->sum('quantity'));
                $outData->push(StockTransaction::whereDate('transaction_date', $date->format('Y-m-d'))->where('transaction_type', 'out')->sum('quantity'));
            }
        }

        $recentProducts = Product::orderBy('created_at', 'desc')->take(5)->get();
        $recentTransactions = StockTransaction::with('stockBatch.productVariation.product')
            ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
            ->when($type, fn($q) => $q->where('transaction_type', $type))
            ->orderBy('transaction_date', 'desc')->take(5)->get();

        return view('pages.admin.products', [
            'productCount' => Product::count(),
            'batchCount' => StockBatch::count(),
            'transactionCount' => $transactionCount,
            'days' => $days,
            'inData' => $inData,
            'outData' => $outData,
            'recentProducts' => $recentProducts,
            'recentTransactions' => $recentTransactions,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'type' => $type,
        ]);
    }
}
