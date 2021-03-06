<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductReview
 * @package App\Models
 * @version April 15, 2020, 9:16 pm CST
 *
 */
class ProductReview extends Model
{
    protected static function boot()
    {
        parent::boot();
//        static::created(function (ProductReview $review){
//            /** @var Product $product */
//            $product = $review->product;
//            $product->rating= $product->avgRating();
//            $product->save();
//        });
//        static::deleted(function (ProductReview $review){
//            /** @var Product $product */
//            $product = $review->product;
//            $product->rating= $product->avgRating();
//            $product->save();
//        });
    }


    public $table = 'product_reviews';
//    public $fillable = [
//    ];
    public $guarded=[];
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

    public function format()
    {
        return [
            'user'       => [
                'name'   => $this->user->name,
                'avatar' => $this->user->avatarUrl,
            ],
            'rating'     => $this->rating,
            'content'    => $this->content,
            'created_at' => $this->created_at,
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function likeUsers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_like_review')->withTimestamps();
    }

    public function hasLikeUser(): bool
    {
        return $this->likeUsers->count() > 0;
    }
    public function upLike(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->likeUsers()->wherePivot('like',User::TYPE_LIKE);
    }

    public function downLike(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->likeUsers()->wherePivot('like',User::TYPE_UNLIKE);
    }

    public function upLikeUserCount(): int
    {
        return $this->likeUsers()->wherePivot('like', User::TYPE_LIKE)->count();
    }

    public function downLikeUserCount(): int
    {
        return $this->likeUsers()->wherePivot('like', User::TYPE_UNLIKE)->count();
    }

    public function score(){
        $up = $this->upLike()->sum('like');
        $down = $this->downLike()->sum('like');
        return $up+$down;
    }


}
