<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class SkuAttributeKey
 * @package App\Models
 * @version April 15, 2020, 9:18 pm CST
 *
 */
class SkuAttributeKey extends Model
{

    public $table = 'sku_attribute_keys';




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


}
