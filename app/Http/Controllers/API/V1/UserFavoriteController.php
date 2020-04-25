<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Repositories\ProductRepository;
use App\Services\FavoriteProductService;
use App\User;
use Illuminate\Http\Request;

class UserFavoriteController extends AppBaseController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var FavoriteProductService
     */
    private $favoriteProductService;

    public function __construct(FavoriteProductService $favoriteProductService, ProductRepository $productRepository)
    {
        $this->middleware('auth:api');
        $this->productRepository = $productRepository;
        $this->favoriteProductService = $favoriteProductService;
    }

    public function userFavoriteProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = auth('api')->user();
        $products = $user->favoriteProducts;
        if (!$products) {
            return $this->sendSuccess('User is not favaorite any product');
        }
        return $this->sendResponse($products, 'User favorites products retrieve successfully');
    }

    public function favorite(Request $request): \Illuminate\Http\JsonResponse
    {
        $validate_data = $request->validate([
            'product_id'=> ['required','integer']
        ]);
        $product_id = $validate_data['product_id'];
        $product = $this->productRepository->findOrFail($product_id);
        /** @var User $user */
        $user = auth('api')->user();

        $this->favoriteProductService->favoriteProduct($user, $product_id);

        return $this->sendSuccess("user {$user->name} favorite {$product_id} ");
    }

    public function clearFavorite(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = auth('api')->user();

        $this->favoriteProductService->clearFavorite($user);

        return $this->sendSuccess('user all favorites has been cleared ');
    }

    public function cancelFavorite(Request $request): \Illuminate\Http\JsonResponse
    {
        $validate_data = $request->validate([
            'product_id'=> ['required','integer']
        ]);
        $product_id = $validate_data['product_id'];
        $product = $this->productRepository->findOrFail($product_id);
        /** @var User $user */
        $user = auth('api')->user();
        $this->favoriteProductService->cancelFavoriteProduct($user, $product_id);

        return $this->sendSuccess("user {$user->name} cancel favorite {$product_id} ");
    }

    public function addFavoriteProductToCart(Request $request)
    {
        $validate_data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);
        $product_id = $validate_data['product_id'];
        /** @var User $user */
        $user = auth('api')->user();
        $this->favoriteProductService->addFavoriteProductToCart($user, $product_id);

        return $this->sendSuccess('product has been add to cart');
    }

    public function checkoutToCart(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        $this->favoriteProductService->checkoutToCart($user);
    }

}
