<?php

namespace App\Http\Controllers\API\V1\Admin ;

use App\Http\Requests\Admin\CreateSkuAttributeValueAPIRequest;
use App\Http\Requests\Admin\UpdateSkuAttributeValueAPIRequest;
use App\Models\SkuAttributeValue;
use App\Repositories\SkuAttributeValueRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SkuAttributeValueController
 * @package App\Http\Controllers\API\V1\Admin 
 */

class SkuAttributeValueAPIController extends AppBaseController
{
    /** @var  SkuAttributeValueRepository */
    private $skuAttributeValueRepository;

    public function __construct(SkuAttributeValueRepository $skuAttributeValueRepo)
    {
        $this->skuAttributeValueRepository = $skuAttributeValueRepo;
    }

    /**
     * Display a listing of the SkuAttributeValue.
     * GET|HEAD /skuAttributeValues
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $skuAttributeValues = $this->skuAttributeValueRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($skuAttributeValues->toArray(), 'Sku Attribute Values retrieved successfully');
    }

    /**
     * Store a newly created SkuAttributeValue in storage.
     * POST /skuAttributeValues
     *
     * @param CreateSkuAttributeValueAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSkuAttributeValueAPIRequest $request)
    {
        $input = $request->all();

        $skuAttributeValue = $this->skuAttributeValueRepository->create($input);

        return $this->sendResponse($skuAttributeValue->toArray(), 'Sku Attribute Value saved successfully');
    }

    /**
     * Display the specified SkuAttributeValue.
     * GET|HEAD /skuAttributeValues/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SkuAttributeValue $skuAttributeValue */
        $skuAttributeValue = $this->skuAttributeValueRepository->find($id);

        if (empty($skuAttributeValue)) {
            return $this->sendError('Sku Attribute Value not found');
        }

        return $this->sendResponse($skuAttributeValue->toArray(), 'Sku Attribute Value retrieved successfully');
    }

    /**
     * Update the specified SkuAttributeValue in storage.
     * PUT/PATCH /skuAttributeValues/{id}
     *
     * @param int $id
     * @param UpdateSkuAttributeValueAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSkuAttributeValueAPIRequest $request)
    {
        $input = $request->all();

        /** @var SkuAttributeValue $skuAttributeValue */
        $skuAttributeValue = $this->skuAttributeValueRepository->find($id);

        if (empty($skuAttributeValue)) {
            return $this->sendError('Sku Attribute Value not found');
        }

        $skuAttributeValue = $this->skuAttributeValueRepository->update($input, $id);

        return $this->sendResponse($skuAttributeValue->toArray(), 'SkuAttributeValue updated successfully');
    }

    /**
     * Remove the specified SkuAttributeValue from storage.
     * DELETE /skuAttributeValues/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SkuAttributeValue $skuAttributeValue */
        $skuAttributeValue = $this->skuAttributeValueRepository->find($id);

        if (empty($skuAttributeValue)) {
            return $this->sendError('Sku Attribute Value not found');
        }

        $skuAttributeValue->delete();

        return $this->sendSuccess('Sku Attribute Value deleted successfully');
    }
}
