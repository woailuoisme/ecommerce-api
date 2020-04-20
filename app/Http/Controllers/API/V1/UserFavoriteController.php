<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\Services\AppbaseService;
use App\User;
use Illuminate\Http\Request;

class UserFavoriteController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth:api');
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
        $product = Product::find($product_id);
        if (empty($product)) {
            return $this->sendError("product $product_id is not exists");
        }
        /** @var User $user */
        $user = auth('api')->user();
        if ($user->existsFavoriteProduct($product_id)) {
            return $this->sendError('product has been favorite');
        }
        $user->favoriteProducts()->attach($product_id);
        return $this->sendSuccess("user {$user->name} favorite {$product_id} ");
    }

    public function clearFavorite(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = auth('api')->user();
        $user->favoriteProducts()->detach();

        return $this->sendSuccess('user all favorites has been cleared ');
    }

    public function cancelFavorite(Request $request): \Illuminate\Http\JsonResponse
    {
        $validate_data = $request->validate([
            'product_id'=> ['required','integer']
        ]);
        $product_id = $validate_data['product_id'];
        $product = Product::find($product_id);
        if (empty($product)) {
            return $this->sendError("product $product_id is not exists");
        }
        /** @var User $user */
        $user = auth('api')->user();
        if ($user->existsFavoriteProduct($product_id)) {
            $user->favoriteProducts()->detach($product_id);

            return $this->sendSuccess("user {$user->name} cancel favorite {$product_id} ");
        } else {
            return $this->sendError('product is\'t be favorite');
        }
    }
}
