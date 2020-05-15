<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models
 * @version April 15, 2020, 9:14 pm CST
 *
 */
class Product extends Model
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
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


    public const SALE_TRUE = 1;
    public const SALE_FALSE = 0;

    public const QUERY_ALL = 0;
    public const QUERY_NEWEST = 1;
    public const QUERY_HOT = 2;
    public const QUERY_RECOMMEND = 3;

    public const MEDIA_TYPE_COVER = 'cover';
    public const MEDIA_TYPE_ALBUM = 'album';

    public function format(): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'description'      => $this->description,
            'rating'           => $this->rating,
            'content'          => $this->content,
            'imageURL'         => $this->image,
            'price'            => $this->price,
            'created_at'       => $this->created_at->toDateTimeString(),
            'updated_at'       => $this->updated_at->toDateTimeString(),
            'updated_at_human' => $this->updated_at->diffforhumans(),
        ];
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function hasReviews(): bool
    {
        return $this->reviews()->count() > 0;
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id')->latest();
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class, 'product_id', 'id');
    }

    public function albums(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->where('custom_type', self::MEDIA_TYPE_ALBUM);
    }

    public function coverImage(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('custom_type', self::MEDIA_TYPE_COVER);
    }

    public function setSkuAttribute(array $skuArr)
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

    /**
     * SELECT * WHERE hub_id = 100 AND (name LIKE `%searchkey%` OR surname LIKE `%searchkey%`):
     * $model->byFieldListLike(['name', 'surname'], 'searchkey');
     */
    public function scopeByFieldListLike($query, $fields, $value)
    {
        $query->where(function ($query) use ($fields, $value) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', "%".$value."%");
            }
        });

        return $query;
    }

    public function getRatingAttribute()
    {
        return round(2 * $this->reviews()->avg('rating')) / 2;
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
            ->withCount('category')
            ->with('skus')
            ->with('reviews');
    }

}
