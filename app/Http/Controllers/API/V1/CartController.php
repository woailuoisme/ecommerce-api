<?php

namespace App\Http\Controllers\API\V1;

//use App\Events\CartCheckoutEvent;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CartController
 * @package App\Http\Controllers\API
 */
class CartController extends AppBaseController
{
    /**
     * @var CartService
     */
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->middleware('auth:api');
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
//        dd(Auth::guard('api'));
        $cart = Auth::guard('api')->user()->cart()->with('products')->get()->first();
        return $this->sendResponse($cart ? new CartResource($cart) : null, 'Carts retrieved successfully');
    }

    public function addProductToCart(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
        ]);
        /** @var User $user */
        $user = auth('api')->user();

        return $this->cartService->addProductToCart($user, $validatedData['product_id']);
    }

    public function updateProductQuantity(Request $request): ?\Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);
        /** @var User $user */
        $user = auth('api')->user();

        return $this->cartService->updateProductQuantity($user,
            $validatedData['product_id'],
            $validatedData['quantity']);
    }

    public function clearCart(): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = auth('api')->user();

        return $this->cartService->clearCart($user);
    }

    public function removeSingle(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
        ]);
        /** @var User $user */
        $user = auth('api')->user();

        return $this->cartService->removeSingle($user, $validatedData['product_id']);
    }

    public function removeSome(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'product_ids' => 'required|array',
        ]);
        /** @var User $user */
        $user = auth('api')->user();

        return $this->cartService->removeMulti($user, $validatedData['product_ids']);
    }

    public function checkout(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var User $user */
        $user = auth('api')->user();

        return $this->cartService->checkout($user);
    }

}
