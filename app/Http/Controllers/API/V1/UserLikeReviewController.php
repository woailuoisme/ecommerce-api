<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class UserLikeReviewController extends AppBaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    private function __construct(UserRepository $userRepository, ProductRepository $productRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function likeReview(Request $request): ?\Illuminate\Http\JsonResponse
    {
        $validate_data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);
        $product_id = $validate_data['product_id'];
        $product = $this->productRepository->findOrFail($product_id);
        /** @var User $user */
        $user = auth('api')->user();
        $this->userRepository->setModel($user)->likeReview($product_id, true);

        return $this->sendSuccess('You liked successfully product');
    }

    public function unlikeReview(Request $request): ?\Illuminate\Http\JsonResponse
    {
        $validate_data = $request->validate([
            'product_id' => ['required', 'integer'],
        ]);
        $product_id = $validate_data['product_id'];
        $product = $this->productRepository->findOrFail($product_id);
        /** @var User $user */
        $user = auth('api')->user();
        $this->userRepository->setModel($user)->likeReview($product_id, false);
        return $this->sendSuccess('You unlike successfully product');
    }


}
