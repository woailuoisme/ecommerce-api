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

    public function index()
    {
        return $this->sendResponse(ProductCategory::all(), 'ProductCategory retrieved Successfully');
    }

    public function show($id)
    {
        /** @var ProductCategory $productCategory */
        $productCategory = $this->repository->find($id);
        if (empty($productCategory)) {
            return $this->sendError('Product Category not found');
        }

        return $this->sendResponse($productCategory->toArray(), 'Product Category retrieved successfully');
    }

    public function categoryProducts($cateID)
    {
        /** @var ProductCategory $category */
        $category = $this->repository->find($cateID);
        $products = $category->products;

        return $this->sendResponse($products);
    }

    public function categoryProduct($cateID, $prodcutid)
    {
        /** @var ProductCategory $category */
        $category = $this->repository->find($cateID);
        $products = $category->products()->where();
    }
}
