<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models
 * @version April 15, 2020, 9:14 pm CST
 *
 */
class Product extends Model
{

    public $table = 'products';




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
