<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package App\Models
 * @version April 15, 2020, 9:20 pm CST
 *
 */
class Address extends Model
{

    public $table = 'addresses';




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
