<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Http\Resources\OrderResource;
use App\Models\Order;
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
        /** @var User $user */
        $user = Auth::guard('api')->user();
        $orders = $user->orders()->with('products')->get();

        return $this->sendResponse(['count' => $orders->count(), 'data' => OrderResource::collection($orders)],
            'Orders retrieved successfully');
    }

    public function show($order_id)
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();
        $order = $user->orders()->with('products')->findOrFail($order_id);

        return $this->sendData(new OrderResource($order));

    }

    public function pay($order_id)
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();
        $order = $user->orders()->findOrFail($order_id);
        $order->order_status = Order::ORDER_STATUS_PAY_SUCCESS;
//        $order->order_status= Order::ORDER_STATUS_PAY_PENDING;
        $order->save();

        return $this->sendData(new OrderResource($order));
    }

    public function cancleOrder($order_id)
    {
        $user = Auth::guard('api')->user();
        $order = $user->orders()->findOrFail($order_id);
        $order->order_status = Order::ORDER_STATUS_PAY_CLOSE;
//        $order->order_status= Order::ORDER_STATUS_PAY_PENDING;
        $order->save();

        return $this->sendData(new OrderResource($order));
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

    public function orderPay(Request $request){
        $validate_data = $request->validate([
            'order_id' => ['required'],
        ]);
        
    }

}


