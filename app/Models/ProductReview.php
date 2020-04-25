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

    public function upLikeUserCount(): int
    {
        return $this->likeUsers()->wherePivot('like', User::TYPE_LIKE)->count();
    }

    public function downLikeUserCount(): int
    {
        return $this->likeUsers()->wherePivot('like', User::TYPE_UNLIKE)->count();
    }


}
