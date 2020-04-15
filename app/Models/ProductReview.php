<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductReview
 * @package App\Models
 * @version April 15, 2020, 9:16 pm CST
 *
 */
class ProductReview extends Model
{

    public $table = 'product_reviews';
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
