<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBatch extends Model
{
    //
    protected $fillable = [
        'product_variation_id',
        'batch_number',
        'unit_price',
        'quantity',
        'has_expiry',
        'manufacture_date',
        'expiry_date',
        'status',
    ];

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}
