<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /** @var Order */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'                => $this->resource->id,
            'user_id'           => $this->resource->user_id,
            'total_price'       => $this->resource->totalProductsPrice(),
            'products_count'    => $this->resource->productsCount(),
            'order_status'      => $this->resource->order_status,
            'order_status_text' => $this->resource->statusText(),
        ];
        if ($this->resource->relationLoaded('products')) {
            $data['products'] = $this->resource->products->map(function (Product $product) {
                return [
                    'id'          => $product->id,
                    'name'        => $product->title,
                    'description' => $product->description,
                    'price'       => $product->price,
                    'quantity'    => $product->pivot->quantity,
                ];
            });
        }

        return $data;

    }
}
