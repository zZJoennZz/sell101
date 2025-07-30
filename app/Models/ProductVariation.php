<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    //
    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price',
        'stock',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function batch()
    {
        return $this->hasMany(StockBatch::class);
    }
}
