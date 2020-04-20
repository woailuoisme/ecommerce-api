<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Http\Resources\OrderResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $orders = Auth::guard('api')->user()->orders()->with('products')->get();

        return $this->sendResponse(OrderResource::collection($orders), 'Orders retrieved successfully');
    }

    public function addAddress($orderId, Request $request)
    {
        $validate_data = $request->validate([
            'address' => ['required'],
        ]);
        /** @var User $user */
        $user = Auth::guard('api')->user();

        $order = $user->orders()->find($$orderId);
        $order->address = $validate_data['address'];
        $order->save();

        return $this->sendSuccess('Order Address update successfully');
    }

}

//       $user-

