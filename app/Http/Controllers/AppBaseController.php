<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use InfyOm\Generator\Utils\ResponseUtil;

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

    public function sendResponseWithoutMsg($data, $code = 200): \Illuminate\Http\JsonResponse
    {
        return Response::json([
            'success' => true,
            'data'    => $data,
        ], $code);
    }

    public function sendError($error, $code = 400): \Illuminate\Http\JsonResponse
    {
        return Response::json($this->_makeError($error), $code);
    }

    public function sendSuccess($message, $code=200): \Illuminate\Http\JsonResponse
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], $code);
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
}
