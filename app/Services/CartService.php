<?php


namespace App\Services;


//use App\Events\CartCheckoutEvent;
use App\Models\Cart;
use App\Models\Order;
use App\Repositories\CartRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService extends AppbaseService
{
    /** @var CartRepository */
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addProductToCart($product_id)
    {
        $result = DB::transaction(function () use ($product_id) {
            /** @var User $user */
            $user = Auth::guard('api')->user();
            $cart = $user->cart;
            if (empty($cart)) {
                $this->cartRepository->create(['user_id' => $user->id]);
            }
            $this->cartRepository->setModel($cart)->addProductToCart($product_id);
            return $this->sendSuccess("product $product_id added in user's cart ");
        });
        return $result;
    }

    public function updateProductQuantity($product_id, $quantity)
    {
        $result = DB::transaction(function () use ($product_id, $quantity) {
            /** @var Cart $cart */
            $cart = Auth::guard('api')->user()->cart;
            $this->cartRepository->setModel($cart)->updateProductQuantity($product_id, $quantity);
            return $this->sendSuccess("product $product_id  quantity update $quantity ");
        });
        return $result;
    }

    public function clearCart()
    {
        $result = DB::transaction(function () {
            /** @var User $user */
            $user = Auth::guard('api')->user();
            /** @var Cart $cart */
            $cart = $user->cart;
            $this->cartRepository->setModel($cart)->clearProductsFromCart();
            return $this->sendSuccess("User({$user->name} cart has cleared ");
        });
        return $result;
    }

    public function removeSingle($product_id): \Illuminate\Http\JsonResponse
    {
        /** @var Cart $user */
        $user = Auth::guard('api')->user();
        /** @var Cart $cart */
        $cart =$user->cart;
        $this->cartRepository->setModel($cart)->removeSingleProductFromCart($product_id);
        return $this->sendSuccess(" product $product_id has beeen removed in cart");
    }

    public function removeMulti($product_ids)
    {
        $result = DB::transaction(function () use ($product_ids) {
            /** @var Cart $cart */
            $cart = Auth::guard('api')->user()->cart;
            $this->cartRepository->setModel($cart)->removeMultiProductsFromCart($product_ids);
            return $this->sendSuccess("products $product_ids cart has cleared ");
        });
        return $result;
    }

    public function checkout()
    {
        $result = DB::transaction(function () {
            /** @var Cart $user */
            $user = Auth::guard('api')->user();
            /** @var Cart $cart */
            $cart = $user->cart;
            if (!$cart) {
                return $this->sendError("User {$user->id} is\'t has cart ");
            }
            try{
                $this->cartRepository->setModel($cart)->cartCheckout();
            }catch (\Exception $e){
                return $this->sendError($e->getMessage());
            }
            return $this->sendSuccess('Order has been created');

        });
        return $result;
    }

}
