<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCategory
 * @package App\Models
 * @version April 15, 2020, 9:13 pm CST
 *
 */
class ProductCategory extends Model
{
    public $table = 'product_categories';

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
            'name'  => $this->name,
            'image' => $this->image,
        ];
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function coverImage(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }


}
