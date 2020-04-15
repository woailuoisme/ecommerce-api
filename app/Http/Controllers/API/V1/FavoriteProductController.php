<?php


namespace App\Http\Controllers\API\V1;


//use App\Events\CartCheckoutEvent;
use App\Http\Controllers\AppBaseController;
use App\Http\Services\FavoriteProductService;

class FavoriteProductController extends AppBaseController
{
    /** @var FavoriteProductService  */
    public  $service;
    public function __construct(FavoriteProductService $service)
    {
        $this->middleware('auth:api');
        $this->service =$service;
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
