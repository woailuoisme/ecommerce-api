<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return $this->sendData($category->products);
    }


    public function uploadCover(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => ['required'],
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = ProductCategory::findOrFail($validatedData['category_id']);

        if ($request->hasFile('cover_image')) {
            $uploadedFile = $request->file('cover_image');
            $file_path = $uploadedFile->store('categories', ['disk' => 'public']);
            $fileInfo = [
                'original_path' => $file_path,
                'mime_type'     => $uploadedFile->getMimeType(),
                'size'          => $uploadedFile->getSize(),
            ];
            if ($category->coverImage && $path = $category->coverImage->original_path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $category->coverImage()->update($fileInfo);
            } else {
                $category->coverImage()->create($fileInfo);
            }
        }
    }
}
