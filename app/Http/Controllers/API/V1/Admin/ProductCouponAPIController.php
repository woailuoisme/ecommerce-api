<?php

namespace App\Http\Controllers\API\V1\Admin ;

use App\Http\Requests\Admin\CreateProductCouponAPIRequest;
use App\Http\Requests\Admin\UpdateProductCouponAPIRequest;
use App\Models\ProductCoupon;
use App\Repositories\ProductCouponRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProductCouponController
 * @package App\Http\Controllers\API\V1\Admin 
 */

class ProductCouponAPIController extends AppBaseController
{
    /** @var  ProductCouponRepository */
    private $productCouponRepository;

    public function __construct(ProductCouponRepository $productCouponRepo)
    {
        $this->productCouponRepository = $productCouponRepo;
    }

    /**
     * Display a listing of the ProductCoupon.
     * GET|HEAD /productCoupons
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $productCoupons = $this->productCouponRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($productCoupons->toArray(), 'Product Coupons retrieved successfully');
    }

    /**
     * Store a newly created ProductCoupon in storage.
     * POST /productCoupons
     *
     * @param CreateProductCouponAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProductCouponAPIRequest $request)
    {
        $input = $request->all();

        $productCoupon = $this->productCouponRepository->create($input);

        return $this->sendResponse($productCoupon->toArray(), 'Product Coupon saved successfully');
    }

    /**
     * Display the specified ProductCoupon.
     * GET|HEAD /productCoupons/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ProductCoupon $productCoupon */
        $productCoupon = $this->productCouponRepository->find($id);

        if (empty($productCoupon)) {
            return $this->sendError('Product Coupon not found');
        }

        return $this->sendResponse($productCoupon->toArray(), 'Product Coupon retrieved successfully');
    }

    /**
     * Update the specified ProductCoupon in storage.
     * PUT/PATCH /productCoupons/{id}
     *
     * @param int $id
     * @param UpdateProductCouponAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductCouponAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProductCoupon $productCoupon */
        $productCoupon = $this->productCouponRepository->find($id);

        if (empty($productCoupon)) {
            return $this->sendError('Product Coupon not found');
        }

        $productCoupon = $this->productCouponRepository->update($input, $id);

        return $this->sendResponse($productCoupon->toArray(), 'ProductCoupon updated successfully');
    }

    /**
     * Remove the specified ProductCoupon from storage.
     * DELETE /productCoupons/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ProductCoupon $productCoupon */
        $productCoupon = $this->productCouponRepository->find($id);

        if (empty($productCoupon)) {
            return $this->sendError('Product Coupon not found');
        }

        $productCoupon->delete();

        return $this->sendSuccess('Product Coupon deleted successfully');
    }
}
