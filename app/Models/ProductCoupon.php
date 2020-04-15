<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCoupon
 * @package App\Models
 * @version April 15, 2020, 9:17 pm CST
 *
 */
class ProductCoupon extends Model
{

    public $table = 'product_coupons';




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
