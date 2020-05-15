<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class CartProduct extends Pivot
{
    public function sku()
    {
        return $this->belongsTo(ProductSku::class, 'sku', 'sku_str');
    }
}