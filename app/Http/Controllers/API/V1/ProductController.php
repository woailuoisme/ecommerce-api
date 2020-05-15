<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
//        $products = Product::all();
//        $products = $this->productRepository->paginate(10, 1);
        $page = $request->input('page', 10);
        $type = $request->input('type', 0);
        $products = $this->productRepository->productList($page);

        return $this->sendData($this->paginatorData($products, ProductResource::class));
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $product = $this->productRepository->productDetail($id);
        if (!$product) {
            return $this->sendError("Product $id not found ");
        }

        return $this->sendData(new ProductResource($product));
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

    public function uploadCover(Request $request)
    {
        $validatedData = $request->validate([
            'product_id'  => ['required'],
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($validatedData['category_id']);

        if ($request->hasFile('cover_image')) {
            $uploadedFile = $request->file('cover_image');
            $file_path = $uploadedFile->store('products/cover_images', ['disk' => 'public']);
            $fileInfo = [
                'original_path' => $file_path,
                'mime_type'     => $uploadedFile->getMimeType(),
                'size'          => $uploadedFile->getSize(),
                'custom_type'   => Product::MEDIA_TYPE_COVER,
            ];
            if ($product->coverImage && $path = $product->coverImage->original_path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $product->coverImage()->update($fileInfo);
            } else {
                $product->coverImage()->create($fileInfo);
            }
        }
    }

    public function updaloadAlbum(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'photos'     => 'required|array|max:5',
            'photos.*'   => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        /** @var Product $product */
        $product = Product::findOrFail($validatedData['product_id']);
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            foreach ($files as $file) {
                $file_path = $file->store('products/albums', ['disk' => 'public']);
                $fileInfo = [
                    'original_path' => $file_path,
                    'mime_type'     => $file->getMimeType(),
                    'size'          => $file->getSize(),
                    'custom_type'   => Product::MEDIA_TYPE_ALBUM,
                ];
                if ($product->albums && $path = $product->albums()
                        ->where('original_path', $file_path)
                        ->first()->original_path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                    $product->albums()->where('original_path', $file_path)->update($fileInfo);
                } else {
                    $product->albums()->create($fileInfo);
                }
            }
        }
    }
}
