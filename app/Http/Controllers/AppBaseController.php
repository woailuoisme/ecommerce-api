<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($data, $message = '', $code = 200): \Illuminate\Http\JsonResponse
    {
        return Response::json($this->_makeResponse($message, $data), $code);
    }

    private function _makeResponse($message, $data): array
    {
        if (empty($message)) {
            return [
                'success' => true,
                'data'    => $data,
            ];
        }

        return [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];
    }

    public function sendData($data, $code = 200): \Illuminate\Http\JsonResponse
    {
        return Response::json([
            'success' => true,
            'data'    => $data,
        ], $code);
    }

    public function paginatorData(LengthAwarePaginator $paginator, string $resource): array
    {
        return [
            'meta'  => [
                'per_page'     => $paginator->perPage(),
                'last_page'    => $paginator->lastPage(),
                'current_page' => $paginator->currentPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],
//            'items' => $resource::collection($paginator->items()),
            'items' => call_user_func("$resource::collection", $paginator->items()),
        ];
    }

    public function sendError($error, $code = 400): \Illuminate\Http\JsonResponse
    {
        return Response::json($this->_makeError($error), $code);
    }

    private function _makeError($message, array $data = []): array
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];
        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }

    public function sendSuccess($message, $code = 200): \Illuminate\Http\JsonResponse
    {
        return Response::json([
            'success' => true,
            'message' => $message,
        ], $code);
    }
}
