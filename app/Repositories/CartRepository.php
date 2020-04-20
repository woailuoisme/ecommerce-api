<?php

namespace App\Repositories;

use App\Exceptions\ApiException;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CartRepository
 * @package App\Repositories
 * @version April 15, 2020, 9:21 pm CST
*/
class CartRepository extends BaseRepository
{


    /** @var Cart */
    protected $model;

    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    private $fieldSearchable = [];

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        // TODO: Implement model() method.
        return Cart::class;
    }

    public function existsProduct($product_id): bool
    {
        return $this->model->products()->wherePivot('product_id', $product_id)->exists();
    }

    public function addProductToCart($product_id): void
    {
        if ($this->existsProduct($product_id)) {
            $this->model->products()->wherePivot('product_id', $product_id)->increment('quantity');
        } else {
            $this->model->products()->attach($product_id, ['quantity' => 1]);
        }
    }

    public function updateProductQuantity($product_id, $quantity): void
    {
        if ($this->existsProduct($product_id)) {
//            dd($quantity);
            $this->model->products()->updateExistingPivot($product_id, ['quantity' => $quantity]);
        } else {
            throw new ApiException("product $product_id is't exists in cart");
        }
    }

    public function clearProductsFromCart(): void
    {
        $this->model->products()->detach();
    }

    public function removeSingleProductFromCart($product_id): void
    {
        $this->model->products()->detach($product_id);
    }

    public function removeMultiProductsFromCart($product_ids): void
    {
        $this->model->products()->detach($product_ids);
    }

    public function cartCheckout(): void
    {
        if (!$this->model->hasProducts()) {
            throw new ApiException('cart don\'t has any products');
        }
        /** @var Order $order */
        $order = Order::create([
            'order_status' => Order::ORDER_STATUS_PAY_PENDING,
            'user_id'      => $this->model->user_id,
            'order_num'    => Order::orderNumber(),
            'total_amount' => $this->model->totalPrice(),
        ]);
        foreach ($this->model->products as $product) {
            $order->products()->attach($product->id, ['quantity' => $product->pivot->quantity]);
        }
//        event(new CartCheckoutEvent($order));
        $this->model->products()->detach();
    }


}
