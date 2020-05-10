<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;

class ProductCategoryController extends AppBaseController
{
    /** @var  ProductCategoryRepository */
    private $repository;

    public function __construct(ProductCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(ProductCategory::all(), 'ProductCategory retrieved Successfully');
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        /** @var ProductCategory $productCategory */
        $productCategory = $this->repository->find($id);
        if ($productCategory === null) {
            return $this->sendError('Product Category not found');
        }

        return $this->sendResponse($productCategory->toArray(), 'Product Category retrieved successfully');
    }

    public function categoryProduct($cateID)
    {
        /** @var ProductCategory $category */
        $category = $this->repository->find($cateID);

//        $products = $category->products()->where('producu_id',$prodcutid);
        return $this->sendResponseWithoutMsg($category->products);
    }
}
