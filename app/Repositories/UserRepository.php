<?php


namespace App\Repositories;


use App\Exceptions\ApiException;
use App\Models\Cart;
use App\User;

class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return [];
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        // TODO: Implement model() method.
        return User::class;
    }

    public function favoriteProducts()
    {
        return $this->model->favoriteProducts;
    }

    public function checkoutFavoriteProduct(): void
    {
        /** @var Cart $cart */
        $cart = $this->model->cart;
        if (empty($cart)) {
            $cart = Cart::create([
                'user_id' => $this->id,
            ]);
        }
        if ($this->model->hasFavoriteProducts()) {
            foreach ($this->model->favoriteProducts as $product) {
                $cart->products()->attach($product->id, ['quantity' => 1]);
            }
            $this->model->favoriteProducts()->detach();
        } else {
            throw new ApiException('User is\'t favorite any product');
        }
    }

    public function addFavoriteToCart($product_id): void
    {
        if (!$this->model->existsFavoriteProduct($product_id)) {
            throw new ApiException("product is't been favorite");
        }
        /** @var Cart $cart */
        $cart = $this->model->cart;
        $cart->addProductToCart($product_id);
        $this->model->favoriteProducts()->detach($product_id);
    }

    public function clearFavoriteProducts(): void
    {
        if (!$this->model->hasFavoriteProducts()) {
            throw new ApiException('User did\'t favorite any Product');
        }
        $this->model->favoriteProducts()->detach();
    }

    public function likeReviews(): void
    {
        return $this->model->likeReviews;
    }

    public function favoriteProduct($product_id): void
    {
        $exsits = $this->model->existsFavoriteProduct($product_id);
        if ($exsits) {
            throw  new ApiException('product has been favorite');
        }
        $this->model->favoriteProducts()->attach($product_id);
    }

    public function cancelFavoriteProduct($product_id): void
    {
        $exsits = $this->model->existsFavoriteProduct($product_id);
        if (!$exsits) {
            throw  new ApiException('product has not been favorite');
        }
        $this->model->favoriteProducts()->detach($product_id);
    }

}
