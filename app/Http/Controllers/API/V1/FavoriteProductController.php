<?php


namespace App\Http\Controllers\API\V1;


//use App\Events\CartCheckoutEvent;
use App\Http\Controllers\AppBaseController;
use App\Repositories\UserRepository;
use App\Services\FavoriteProductService;
use App\User;

class FavoriteProductController extends AppBaseController
{
    /**
     * @var FavoriteProductService
     */
    private $service;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param FavoriteProductService $service
     * @param UserRepository $userRepository
     */
    public function __construct(FavoriteProductService $service, UserRepository $userRepository)
    {
        $this->middleware('auth:api');
        $this->service = $service;
        $this->userRepository = $userRepository;
    }

    public function favoriteProducts()
    {
        /** @var User $user */
        $user = auth('api')->user();

        return $user->favoriteProducts->map->format;
    }

    public function addFavoriteProductToCart($product_id): \Illuminate\Http\JsonResponse
    {
        $this->service->addFavoriteProductToCart((int)$product_id);
        return $this->sendSuccess('Favorite product add successfully to cart ');
    }
    public function addAllToCart(): \Illuminate\Http\JsonResponse
    {
        $this->service->checkoutToCart();
        return $this->sendSuccess('Favorite product checkout successfully to cart');
    }

}
