<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    public function sku()
    {
        return $this->belongsTo(ProductSku::class, 'sku', 'sku_str');
    }
}