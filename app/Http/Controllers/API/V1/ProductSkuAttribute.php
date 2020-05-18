<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSkuAttribute extends AppBaseController
{

    public function index(Product $product, Request $request)
    {

        return $this->sendResponse($product->attribute_list, 'Sku Attribute Keys retrieved successfully');
    }

    public function store(Product $product, Request $request)
    {
        $validateData = $request->validate([
            'attribute_list' => ['required', 'json'],
        ]);
        $product->attribute_list = $validateData['attribute_list'];
        $product->save();

        return $this->sendResponse($product->fresh()->attribute_list, 'Sku Attribute Key saved successfully');
    }

    public function update(Product $product, Request $request)
    {
        $validateData = $request->validate([
            'attribute_list' => ['required', 'json'],
        ]);
        $product->attribute_list = $validateData['attribute_list'];
        $product->save();

        return $this->sendResponse($product->fresh()->attribute_list, 'SkuAttributeKey updated successfully');
    }

    public function destory(Product $product, Request $request)
    {
        $validateData = $request->validate([
            'attribute_list' => ['required', 'json'],
        ]);
        $product->attribute_list = null;
        $product->save();

        return $this->sendSuccess('Sku Attribute Key deleted successfully');
    }
}