<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSkuKeyResourece extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'    => $this->name,
            'en_name' => $this->en_name,
            'values'  => $this->whenLoaded('skuValues', ProductSkuValueResourece::collection($this->skuValues)),
        ];
    }
}
