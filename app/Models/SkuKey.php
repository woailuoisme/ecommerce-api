<?php

namespace App\Models;


/**
 * Class SkuAttributeKey
 * @package App\Models
 * @version April 15, 2020, 9:18 pm CST
 *
 */
class SkuKey extends BaseModel
{

    public $table = 'product_sku_attributes_key';


    public $fillable = [
        'name',
        'en_name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


    public function skuValues()
    {
        return $this->hasMany(SkuValue::class, 'key_id', 'id');
    }

    public function hasSkuValues()
    {
        return $this->skuValues && $this->skuValues->count() > 0;
    }



}
