<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    //
    protected $fillable = [
        'stock_batch_id',
        'transaction_type',
        'quantity',
        'transaction_date',
        'remarks',
    ];

    public function stockBatch()
    {
        return $this->belongsTo(StockBatch::class);
    }

    protected static function booted()
    {
        static::created(function ($transaction) {
            $batch = $transaction->stockBatch;
            if ($batch) {
                $variation = $batch->productVariation;
                if ($variation && $variation->product) {
                    // Update batch quantity
                    if ($transaction->transaction_type === 'in') {
                        $batch->quantity += $transaction->quantity;
                    } else {
                        $batch->quantity -= $transaction->quantity;
                    }
                    $batch->save();

                    // Update product stock (sum all batches for this product)
                    $product = $variation->product;
                    $totalStock = $product->variations()
                        ->with('batch')
                        ->get()
                        ->flatMap->batch
                        ->sum('quantity');
                    $product->stock = $totalStock;
                    $product->save();
                }
            }
        });
    }
}
