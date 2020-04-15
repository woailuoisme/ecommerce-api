<?php

namespace App\Http\Controllers\API\V1\Admin ;

use App\Http\Requests\Admin\CreateProductSkuAPIRequest;
use App\Http\Requests\Admin\UpdateProductSkuAPIRequest;
use App\Models\ProductSku;
use App\Repositories\ProductSkuRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProductSkuController
 * @package App\Http\Controllers\API\V1\Admin 
 */

class ProductSkuAPIController extends AppBaseController
{
    /** @var  ProductSkuRepository */
    private $productSkuRepository;

    public function __construct(ProductSkuRepository $productSkuRepo)
    {
        $this->productSkuRepository = $productSkuRepo;
    }

    /**
     * Display a listing of the ProductSku.
     * GET|HEAD /productSkus
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $productSkus = $this->productSkuRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($productSkus->toArray(), 'Product Skus retrieved successfully');
    }

    /**
     * Store a newly created ProductSku in storage.
     * POST /productSkus
     *
     * @param CreateProductSkuAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProductSkuAPIRequest $request)
    {
        $input = $request->all();

        $productSku = $this->productSkuRepository->create($input);

        return $this->sendResponse($productSku->toArray(), 'Product Sku saved successfully');
    }

    /**
     * Display the specified ProductSku.
     * GET|HEAD /productSkus/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ProductSku $productSku */
        $productSku = $this->productSkuRepository->find($id);

        if (empty($productSku)) {
            return $this->sendError('Product Sku not found');
        }

        return $this->sendResponse($productSku->toArray(), 'Product Sku retrieved successfully');
    }

    /**
     * Update the specified ProductSku in storage.
     * PUT/PATCH /productSkus/{id}
     *
     * @param int $id
     * @param UpdateProductSkuAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductSkuAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProductSku $productSku */
        $productSku = $this->productSkuRepository->find($id);

        if (empty($productSku)) {
            return $this->sendError('Product Sku not found');
        }

        $productSku = $this->productSkuRepository->update($input, $id);

        return $this->sendResponse($productSku->toArray(), 'ProductSku updated successfully');
    }

    /**
     * Remove the specified ProductSku from storage.
     * DELETE /productSkus/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ProductSku $productSku */
        $productSku = $this->productSkuRepository->find($id);

        if (empty($productSku)) {
            return $this->sendError('Product Sku not found');
        }

        $productSku->delete();

        return $this->sendSuccess('Product Sku deleted successfully');
    }
}
