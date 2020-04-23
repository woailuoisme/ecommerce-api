<?php


namespace App\Services;


use App\Models\Cart;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteProductService extends AppbaseService
{
    /**
     * @var UserRepository
     */
    private $userRespository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRespository = $userRepository;
    }
    public function addFavoriteProductToCart($product_id): void
    {
         DB::transaction(function () use ($product_id) {
            /** @var User $user */
            $user = Auth::guard('api')->user();
             $this->userRespository->setModel($user)->addFavoriteToCart($product_id);
//            $user->addFavoriteToCart($product_id);
        });
    }
    public function checkoutToCart(): void
    {
        DB::transaction(function ()  {
            /** @var User $user */
            $user = Auth::guard('api')->user();
            /** @var Cart $cart */
            $this->userRespository->setModel($user)->checkoutFavoriteProduct();
//            $user->checkoutFavoriteProduct();
        });
    }
}
