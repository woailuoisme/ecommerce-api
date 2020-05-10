<?php


namespace App\Http\Controllers\API\V1\Admin;


use App\Http\Controllers\AppBaseController;
use App\Models\Order;
use Carbon\Carbon;

class DashBoardController extends AppBaseController
{

    public function index()
    {
//        $this->authorize(['isGeneral']);
        $this->authorize('isGeneral');
//        $this->authorize('isManager');
        //购物车中商品统计 当前被加入购物车商品 Top 5
//        $cart_product_info = DB::table('carts')
//            ->select('products.title','cart_product.product_id', DB::raw('count(*) as total'))
//            ->leftJoin('cart_product', 'carts.id', '=', 'cart_product.cart_id')
//            ->leftJoin('products', 'products.id', '=', 'cart_product.product_id')
//            ->groupBy('cart_product.product_id')
////            ->sum('total')
//            ->orderBy('total','desc')
//            ->get();

        //订单中商品统计 被购买最多的商品Top 5
//        $order_product_info = DB::table('orders')
//            ->select('products.title','order_product.product_id', DB::raw('count(*) as total'))
////            ->where('orders.order_status',Order::ORDER_STATUS_PAY_CLOSE)
//            ->leftJoin('order_product', 'orders.id', '=', 'order_product.order_id')
//            ->leftJoin('products', 'products.id', '=', 'order_product.product_id')
//            ->groupBy('order_product.product_id')
//            ->orderBy('total','desc')
//            ->get();
        //被收藏最多商品统计 被购买最多的商品Top 5

        //被评论做多的商品

        //分类下产品统计

        // 正在销售中产品数

//        $order_product_info_count = $order_product_info->sum('total');
//        $count =$cart_product_info->sum('total');
//        $on_sale_product=Product::where('on_sale',true)->count();
        $order_unpay = Order::where('order_status', Order::ORDER_STATUS_PAY_PENDING)->count();
        $order_paid = Order::where('order_status', Order::ORDER_STATUS_PAY_SUCCESS)->count();
        $order_completed = Order::where('order_status', Order::ORDER_STATUS_PAY_CLOSE)->count();

//        $order_unpay_recently_week =Order::where('order_status',Order::ORDER_STATUS_PAY_PENDING)
//            ->where('updated_at','>=',Carbon::now()->startOfWeek()->toDateTimeString())->count();
//
//        $order_unpay_recently_month =Order::where('order_status',Order::ORDER_STATUS_PAY_PENDING)
//            ->where('updated_at','>=',Carbon::now()->startOfMonth()->subMonth()->toDateTimeString())->count();
//        $order_unpay_group_month =Order::selectRaw("MONTH(created_at) as month,count(*) as total")
//            ->whereBetween('updated_at','>=',Carbon::now()->startOfYear()->toDateTimeString())
//            ->groupBy('month')
//            ->get();

        //本年每月
        $order_unpay_group_month = Order::selectRaw("MONTH(created_at) as month,count(*) as total")
            ->where('updated_at', '>=', Carbon::now()->startOfYear()->toDateTimeString())
            ->groupBy('month')
            ->get();
        //本月每周
        $order_unpay_group_week = Order::selectRaw("WEEK(created_at) as week,count(*) as total")
            ->where('updated_at', '>=', Carbon::now()->startOfMonth()->toDateTimeString())
            ->groupBy('week')
            ->get();

        //本周每天
//        return $this->sendResponse([$order_product_info_count,$order_product_info]);
        $order_unpay_group_day = Order::selectRaw("DAYOFMONTH(created_at) as dayOfWeek,count(*) as total")
            ->where('updated_at', '>=', Carbon::now()->startOfWeek()->toDateTimeString())
            ->groupBy('dayOfWeek')
            ->get();

        return $this->sendResponse([
            'order_unpay_group_month' => $order_unpay_group_month,
            'order_unpay_group_week'  => $order_unpay_group_week,
            'order_unpay_group_day'   => $order_unpay_group_day,
        ]);
    }
}