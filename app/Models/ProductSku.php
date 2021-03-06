<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductSku
 * @package App\Models
 * @version April 15, 2020, 9:15 pm CST
 *
 */
class ProductSku extends Model
{

    public $table = 'product_sku';
    public $fillable = [
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function format(): array
    {
        return [
            'sku_json' => $this->sku_json,
            'sku_str'  => $this->sku_str,
            'stock'    => $this->stock,
            'price'    => $this->price,
        ];
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


}
