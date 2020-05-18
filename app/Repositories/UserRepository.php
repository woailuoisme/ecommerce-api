<?php


namespace App\Repositories;


use App\Exceptions\ApiException;
use App\Models\Cart;
use App\User;
use Illuminate\Container\Container as Application;

class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;
    /**
     * @var CartRepository
     */
    private $cartRepository;

    public function __construct(Application $app, CartRepository $cartRepository)
    {
        parent::__construct($app);
        $this->app = $app;
        $this->cartRepository = $cartRepository;
    }

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
    public function model(): string
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

        if ($this->model->hasFavoriteProducts()) {
            foreach ($this->model->favoriteProducts as $product) {
                $this->cartRepository->addProductToCart($product->id);
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
        $this->cartRepository->setModel($cart)->addProductToCart($product_id);
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

    public function likeReviews()
    {
        return $this->model->likeReviews;
    }

    public function likeOrUnlikeReview($review_id, bool $like): void
    {
        if ($this->model->existsLikeReviews($review_id)) {
            throw new ApiException('', 400);
        }
        if ($like) {
            $this->model->likeReviews()->attach('review_id', ['like' => User::TYPE_LIKE]);
        } else {
            $this->model->likeReviews()->attach('review_id', ['like' => User::TYPE_UNLIKE]);
        }
    }

    public function cancleLikeOrUnlikeReview($review_id): void
    {
        if (!$this->model->existsLikeReviews($review_id)) {
            throw  new ApiException('review is not been liked', 400);
        }
        $this->model->likeReviews()->detach($review_id);

    }


    public function favoriteProduct($product_id): void
    {
        $exsits = $this->model->existsFavoriteProduct($product_id);
        if ($exsits) {
            throw  new ApiException('product has been favorite', 400);
        }
        $this->model->favoriteProducts()->attach($product_id);
    }

    public
    function cancelFavoriteProduct(
        $product_id
    ): void {
        $exists = $this->model->existsFavoriteProduct($product_id);
        if (!$exists) {
            throw  new ApiException('product has not been favorite', 404);
        }
        $this->model->favoriteProducts()->detach($product_id);
    }
}
