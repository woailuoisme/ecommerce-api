<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /** @var Product */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->resource->format();
        if ($this->resource->relationLoaded('reviews')) {
            $data['reviews'] = $this->resource->reviews->map(function ($review) {
                return $review->format();
            });
        }
        if ($this->resource->relationLoaded('skus')) {
            $data['skus'] = $this->resource->skus->map(function ($sku) {
                return $sku->format();
            });
        }
        if ($this->resource->relationLoaded('category')) {
            $data['category'] = $this->resource->category->format();
        }

        return $data;

    }
}
