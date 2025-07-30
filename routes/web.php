<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\StockBatchController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    //admin dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    //product
    Route::get('/products-dashboard', [ProductDashboardController::class, 'index'])->name('admin.productsdash');

    //categories
    Route::get('/view-product-categories', [ProductCategoryController::class, 'index'])->name('admin.productcategories');
    Route::get('/add-product-category', [ProductCategoryController::class, 'create'])->name('admin.addproductcategory');
    Route::post('/add-product-category', [ProductCategoryController::class, 'store'])->name('admin.storeproductcategory');
    Route::get('/edit-product-category/{id}', [ProductCategoryController::class, 'edit'])->name('admin.editproductcategory');
    Route::put('/edit-product-category/{id}', [ProductCategoryController::class, 'update'])->name('admin.updateproductcategory');

    //brands
    Route::get('/view-brands', [BrandController::class, 'index'])->name('admin.brands');
    Route::get('/add-brand', [BrandController::class, 'create'])->name('admin.addbrand');
    Route::post('/add-brand', [BrandController::class, 'store'])->name('admin.storebrand');
    Route::get('/edit-brand/{id}', [BrandController::class, 'edit'])->name('admin.editbrand');
    Route::put('/edit-brand/{id}', [BrandController::class, 'update'])->name('admin.updatebrand');

    //products
    Route::get('/view-products', [ProductController::class, 'index'])->name('admin.products');
    Route::get('/add-product', [ProductController::class, 'create'])->name('admin.addproduct');
    Route::post('/add-product', [ProductController::class, 'store'])->name('admin.storeproduct');
    Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('admin.editproduct');
    Route::put('/edit-product/{id}', [ProductController::class, 'update'])->name('admin.updateproduct');
    Route::delete('/products/{product}/images/{image}', [ProductController::class, 'removeImage'])->name('admin.product.removeimage');

    // stock transactions
    Route::get('/stock-transactions', [StockTransactionController::class, 'index'])->name('admin.stocktransactions');
    Route::get('/add-stock-transaction', [StockTransactionController::class, 'create'])->name('admin.stocktransactions.create');
    Route::post('/add-stock-transaction', [StockTransactionController::class, 'store'])->name('admin.stocktransactions.store');

    // stock batches
    Route::get('/stock-batches', [StockBatchController::class, 'index'])->name('admin.stockbatches');
    Route::get('/add-stock-batch', [StockBatchController::class, 'create'])->name('admin.stockbatches.create');
    Route::post('/add-stock-batch', [StockBatchController::class, 'store'])->name('admin.stockbatches.store');
    Route::get('/edit-stock-batch/{id}', [StockBatchController::class, 'edit'])->name('admin.stockbatches.edit');
    Route::put('/edit-stock-batch/{id}', [StockBatchController::class, 'update'])->name('admin.stockbatches.update');

    // reports
    Route::get('/reports', [ReportController::class, 'all_reports'])->name('admin.reports');
    Route::get('/reports/stock-level', [ReportController::class, 'stock_level_report'])->name('admin.stock-level');
    Route::get('/reports/preview/stock-level-preview', [ReportController::class, 'stock_level'])->name('admin.stock-level-preview');
    Route::get('/reports/stock-movement', [ReportController::class, 'stock_movement_report'])->name('admin.stock-movement');
    Route::get('/reports/preview/stock-movement-preview', [ReportController::class, 'stock_movement'])->name('admin.stock-movement-preview');
    Route::get('/reports/low-stock', [ReportController::class, 'low_stock_report'])->name('admin.low-stock');
    Route::get('/reports/preview/low-stock', [ReportController::class, 'low_stock_print'])->name('admin.low-stock-print');
});

Route::get('/', [PublicController::class, 'home'])->name('public.home');
// Product page route
Route::get('/product/{slug}', [ProductPageController::class, 'show'])->name('product.show');
