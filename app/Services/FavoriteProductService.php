<?php


namespace App\Services;


use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\DB;

class FavoriteProductService extends AppBaseService
{
    /**
     * @var UserRepository
     */
    private $userRespository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRespository = $userRepository;
    }

    public function favoriteProduct(User $user, $prodcut_id): void
    {
        $this->userRespository->setModel($user)->favoriteProduct($prodcut_id);
    }

    public function cancelFavoriteProduct(User $user, $prodcut_id): void
    {
        $this->userRespository->setModel($user)->cancelFavoriteProduct($prodcut_id);
    }

    public function clearFavorite(User $user): void
    {
        DB::transaction(function () use ($user) {
            $this->userRespository->setModel($user)->clearFavoriteProducts();
        });
    }

    public function addFavoriteProductToCart(User $user, $product_id): void
    {
        DB::transaction(function () use ($user, $product_id) {
             $this->userRespository->setModel($user)->addFavoriteToCart($product_id);
        });
    }

    public function checkoutToCart(User $user): void
    {
        DB::transaction(function () use ($user) {
            $this->userRespository->setModel($user)->checkoutFavoriteProduct();
        });
    }
}
