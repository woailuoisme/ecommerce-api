<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Psy\Util\Json;


class ProductController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    public function index(): \Illuminate\Http\JsonResponse
    {
//        $products = Product::all();
        $products = $this->productRepository->paginate(10, 1);
        $products_data = [
            'lastPage'    => $products->lastPage(),
            'currentPage' => $products->currentPage(),
            'total'       => $products->total(),
            'items'       => ProductResource::collection($products->items()),
        ];

        return $this->sendResponseWithoutMsg($products_data);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $product = $this->productRepository->find((int)$id);
        if (!$product) {
            return $this->sendError("Product $id not found ");
        }

        return $this->sendResponseWithoutMsg(new ProductResource($product));
    }

    public function newestProducts()
    {
//        $product = $this->productRepository->find((int)$id);
    }

    public function storeSkuJson(Request $request)
    {
        $validate_data = $request->validate([
            'sku_list' => ['required', 'json'],
        ]);
//        json_decode($validate_data['sku_list'], true);
    }
}
