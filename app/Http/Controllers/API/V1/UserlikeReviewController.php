<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;

class UserlikeReviewController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function likeProduct(Request $request): ?\Illuminate\Http\JsonResponse
    {
        $validate_data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);
        $product_id = $validate_data['product_id'];
        $product = Product::find($product_id);
        if (empty($product)) {
            return $this->sendError("product $product_id is not exists");
        }
        /** @var User $user */
        $user = auth('api')->user();
        $user->likeReview($product_id, User::TYPE_LIKE);

        return $this->sendSuccess('You liked successfully product');
    }

    public function unlikeProduct(Request $request): ?\Illuminate\Http\JsonResponse
    {
        $validate_data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);
        $product_id = $validate_data['product_id'];
        $product = Product::find($product_id);
        if (empty($product)) {
            return $this->sendError("product $product_id is not exists");
        }
        /** @var User $user */
        $user = auth('api')->user();
        $user->likeReview($product_id, User::TYPE_UNLIKE);

        return $this->sendSuccess('You unlike successfully product');
    }

}
