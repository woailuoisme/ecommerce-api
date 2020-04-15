<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\AppbaseService;


class ProductController extends AppBaseController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $products = Product::all();
        return $this->sendResponseWithoutMsg(ProductResource::collection($products));
    }
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $product = Product::find((int)$id)->first();
        if (!$product) {
            return $this->sendError("Product $id not found ");
        }
        return $this->sendResponseWithoutMsg(new ProductResource($product));
    }
}
