<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class SkuAttributeValue
 * @package App\Models
 * @version April 15, 2020, 9:19 pm CST
 *
 */
class SkuAttributeValue extends Model
{

    public $table = 'sku_attribute_values';




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
