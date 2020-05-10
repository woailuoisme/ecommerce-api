<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class SkuAttributeValue
 * @package App\Models
 * @version April 15, 2020, 9:19 pm CST
 *
 */
class SkuValue extends Model
{
    public $table = 'product_sku_attributes_value';

    public $fillable = [
        'value',
        'en_value',
        'en_key_name',
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

    public function skuKey()
    {
        return $this->belongsTo(SkuKey::class, 'sku_attributes_id', 'id');
    }


}
