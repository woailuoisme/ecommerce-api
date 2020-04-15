<?php

namespace App\Http\Controllers\API\V1\Admin ;

use App\Http\Requests\Admin\CreateSkuAttributeKeyAPIRequest;
use App\Http\Requests\Admin\UpdateSkuAttributeKeyAPIRequest;
use App\Models\SkuAttributeKey;
use App\Repositories\SkuAttributeKeyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SkuAttributeKeyController
 * @package App\Http\Controllers\API\V1\Admin 
 */

class SkuAttributeKeyAPIController extends AppBaseController
{
    /** @var  SkuAttributeKeyRepository */
    private $skuAttributeKeyRepository;

    public function __construct(SkuAttributeKeyRepository $skuAttributeKeyRepo)
    {
        $this->skuAttributeKeyRepository = $skuAttributeKeyRepo;
    }

    /**
     * Display a listing of the SkuAttributeKey.
     * GET|HEAD /skuAttributeKeys
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $skuAttributeKeys = $this->skuAttributeKeyRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($skuAttributeKeys->toArray(), 'Sku Attribute Keys retrieved successfully');
    }

    /**
     * Store a newly created SkuAttributeKey in storage.
     * POST /skuAttributeKeys
     *
     * @param CreateSkuAttributeKeyAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSkuAttributeKeyAPIRequest $request)
    {
        $input = $request->all();

        $skuAttributeKey = $this->skuAttributeKeyRepository->create($input);

        return $this->sendResponse($skuAttributeKey->toArray(), 'Sku Attribute Key saved successfully');
    }

    /**
     * Display the specified SkuAttributeKey.
     * GET|HEAD /skuAttributeKeys/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SkuAttributeKey $skuAttributeKey */
        $skuAttributeKey = $this->skuAttributeKeyRepository->find($id);

        if (empty($skuAttributeKey)) {
            return $this->sendError('Sku Attribute Key not found');
        }

        return $this->sendResponse($skuAttributeKey->toArray(), 'Sku Attribute Key retrieved successfully');
    }

    /**
     * Update the specified SkuAttributeKey in storage.
     * PUT/PATCH /skuAttributeKeys/{id}
     *
     * @param int $id
     * @param UpdateSkuAttributeKeyAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSkuAttributeKeyAPIRequest $request)
    {
        $input = $request->all();

        /** @var SkuAttributeKey $skuAttributeKey */
        $skuAttributeKey = $this->skuAttributeKeyRepository->find($id);

        if (empty($skuAttributeKey)) {
            return $this->sendError('Sku Attribute Key not found');
        }

        $skuAttributeKey = $this->skuAttributeKeyRepository->update($input, $id);

        return $this->sendResponse($skuAttributeKey->toArray(), 'SkuAttributeKey updated successfully');
    }

    /**
     * Remove the specified SkuAttributeKey from storage.
     * DELETE /skuAttributeKeys/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SkuAttributeKey $skuAttributeKey */
        $skuAttributeKey = $this->skuAttributeKeyRepository->find($id);

        if (empty($skuAttributeKey)) {
            return $this->sendError('Sku Attribute Key not found');
        }

        $skuAttributeKey->delete();

        return $this->sendSuccess('Sku Attribute Key deleted successfully');
    }
}
