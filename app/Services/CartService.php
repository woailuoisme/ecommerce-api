<?php


namespace App\Services;


//use App\Events\CartCheckoutEvent;
use App\Models\Cart;
use App\Repositories\CartRepository;
use App\User;
use Illuminate\Support\Facades\DB;

class CartService extends AppBaseService
{
    /** @var CartRepository */
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addProductToCart(User $user, $product_id)
    {
        $result = DB::transaction(function () use ($user, $product_id) {
            $cart = $user->cart;
            if (empty($cart)) {
                $this->cartRepository->create(['user_id' => $user->id]);
            }
            $this->cartRepository->setModel($cart)->addProductToCart($product_id);
            return $this->sendSuccess("product $product_id added in user's cart ");
        });
        return $result;
    }

    public function updateProductQuantity(User $user, $product_id, $quantity)
    {
        $result = DB::transaction(function () use ($user, $product_id, $quantity) {
            $this->cartRepository->setModel($user->cart)->updateProductQuantity($product_id, $quantity);
            return $this->sendSuccess("product $product_id  quantity update $quantity ");
        });
        return $result;
    }

    public function clearCart(User $user)
    {
        $result = DB::transaction(function () use ($user) {
            $cart = $user->cart;
            $this->cartRepository->setModel($cart)->clearProductsFromCart();
            return $this->sendSuccess("User({$user->name} cart has cleared ");
        });
        return $result;
    }

    public function removeSingle(User $user, $product_id): \Illuminate\Http\JsonResponse
    {
        /** @var Cart $cart */
        $cart =$user->cart;
        $this->cartRepository->setModel($cart)->removeSingleProductFromCart($product_id);
        return $this->sendSuccess(" product $product_id has beeen removed in cart");
    }

    public function removeMulti(User $user, $product_ids)
    {
        $result = DB::transaction(function () use ($user, $product_ids) {
            $this->cartRepository->setModel($user->cart)->removeMultiProductsFromCart($product_ids);
            return $this->sendSuccess("products $product_ids cart has cleared ");
        });
        return $result;
    }

    public function checkout(User $user)
    {
        $result = DB::transaction(function () use ($user) {
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
