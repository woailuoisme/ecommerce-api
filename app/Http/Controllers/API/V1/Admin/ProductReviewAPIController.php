<?php

namespace App\Http\Controllers\API\V1\Admin ;

use App\Http\Requests\Admin\CreateProductReviewAPIRequest;
use App\Http\Requests\Admin\UpdateProductReviewAPIRequest;
use App\Models\ProductReview;
use App\Repositories\ProductReviewRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProductReviewController
 * @package App\Http\Controllers\API\V1\Admin 
 */

class ProductReviewAPIController extends AppBaseController
{
    /** @var  ProductReviewRepository */
    private $productReviewRepository;

    public function __construct(ProductReviewRepository $productReviewRepo)
    {
        $this->productReviewRepository = $productReviewRepo;
    }

    /**
     * Display a listing of the ProductReview.
     * GET|HEAD /productReviews
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $productReviews = $this->productReviewRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($productReviews->toArray(), 'Product Reviews retrieved successfully');
    }

    /**
     * Store a newly created ProductReview in storage.
     * POST /productReviews
     *
     * @param CreateProductReviewAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProductReviewAPIRequest $request)
    {
        $input = $request->all();

        $productReview = $this->productReviewRepository->create($input);

        return $this->sendResponse($productReview->toArray(), 'Product Review saved successfully');
    }

    /**
     * Display the specified ProductReview.
     * GET|HEAD /productReviews/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ProductReview $productReview */
        $productReview = $this->productReviewRepository->find($id);

        if (empty($productReview)) {
            return $this->sendError('Product Review not found');
        }

        return $this->sendResponse($productReview->toArray(), 'Product Review retrieved successfully');
    }

    /**
     * Update the specified ProductReview in storage.
     * PUT/PATCH /productReviews/{id}
     *
     * @param int $id
     * @param UpdateProductReviewAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductReviewAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProductReview $productReview */
        $productReview = $this->productReviewRepository->find($id);

        if (empty($productReview)) {
            return $this->sendError('Product Review not found');
        }

        $productReview = $this->productReviewRepository->update($input, $id);

        return $this->sendResponse($productReview->toArray(), 'ProductReview updated successfully');
    }

    /**
     * Remove the specified ProductReview from storage.
     * DELETE /productReviews/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ProductReview $productReview */
        $productReview = $this->productReviewRepository->find($id);

        if (empty($productReview)) {
            return $this->sendError('Product Review not found');
        }

        $productReview->delete();

        return $this->sendSuccess('Product Review deleted successfully');
    }
}
