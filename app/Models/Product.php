<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Psy\Util\Json;

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
        'id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id')->latest();
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class, 'product_id', 'id');
    }

    public function setSkuAttribute(Array $skuArr)
    {
        $this->attributes['attribute_list'] = json_encode($skuArr);
    }

    public function getSkuAttribute()
    {
        return $this->attributes['attribute_list'] ? json_decode($this->attributes['attribute_list'], true) : '';
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostReviews(Builder $query)
    {
        // comments_count
        return $query->withCount('reviews')->orderBy('reviews_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
            ->withCount('category')
            ->with('skus')
            ->with('reviews');
    }


}
