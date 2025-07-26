<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    //
    protected $fillable = [
        'product_id',
        'product_variation_id',
        'user_id',
        'rating',
        'comment',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
