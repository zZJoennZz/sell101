<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $productCount = Product::count();

        $recentTransactions = StockTransaction::with('stockBatch.productVariation.product')
            ->when($dateFrom, fn($q) => $q->whereDate('transaction_date', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->whereDate('transaction_date', '<=', $dateTo))
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        // Placeholder for orders and other stats
        $orderCount = 0;
        $pendingOrders = 0;
        $completedOrders = 0;

        return view('pages.admin.dashboard', [
            'productCount' => $productCount,
            'recentTransactions' => $recentTransactions,
            'orderCount' => $orderCount,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }
}
