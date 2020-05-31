<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


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
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $type = $request->input('type', Product::QUERY_ALL);
        $products = $this->productRepository->products($page,$perPage);

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

    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => ['required'],
            'image'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type'       => [
                'required',
                Rule::in([
                    Product::MEDIA_TYPE_COVER,
                    Product::MEDIA_TYPE_ALBUM,
                    Product::MEDIA_TYPE_CONTENT,
                ]),
            ],
        ]);

        $product = Product::findOrFail($validatedData['product_id']);

        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');

            $file_path = $uploadedFile->store("products/{$validatedData['type']}", ['disk' => 'public']);
            $fileInfo = [
                'original_path' => $file_path,
                'mime_type'     => $uploadedFile->getMimeType(),
                'size'          => $uploadedFile->getSize(),
                'custom_type'   => $validatedData['type'],
            ];
            $imageUrl=null;
            switch ($validatedData['type']) {
                case Product::MEDIA_TYPE_CONTENT:
                    if ($product->contentImage && $path = $product->contentImage->original_path) {
                        if (Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                        $product->contentImage()->update($fileInfo);
                    } else {
                        $product->contentImage()->create($fileInfo);
                    }
                    break;
                case Product::MEDIA_TYPE_ALBUM:
                    if ($product->albums && $image = $product->albums()
                            ->where('original_path', $file_path)
                            ->first()) {
                        if (Storage::disk('public')->exists($image->original_path)) {
                            Storage::disk('public')->delete($image->original_path);
                        }
                        $product->albums()->where('original_path', $file_path)->update($fileInfo);
                    } else {
                        $product->albums()->create($fileInfo);
                    }
                    break;
                case Product::MEDIA_TYPE_COVER:
                    if ($product->coverImage && $path = $product->coverImage->original_path) {
                        if (Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                        $product->coverImage()->update($fileInfo);
                    } else {
                        $product->coverImage()->create($fileInfo);
                    }
                    break;
            }
        }
        return $this->sendData(Storage::disk('public')->url($fileInfo['original_path']));
    }

    public function uploadMultiAlbum(Request $request)
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
