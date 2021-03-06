<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Order
 * @package App\Models
 * @version April 15, 2020, 9:22 pm CST
 *
 */
class Order extends Model
{

    public const ORDER_STATUS_PAY_PENDING = 'pay_pending';  // 未支付
    public const ORDER_STATUS_PAY_SUCCESS = 'pay_success';    // 已支付
    public const ORDER_STATUS_PAY_CLOSE = 'closed';    // 已关闭

    public const ORDER_STATUS_SHIP_PENDING = 'ship_pending';  // 未发货
    public const ORDER_STATUS_SHIP_DELIVERED = 'ship_delivered';  // 已发货
    public const ORDER_STATUS_SHIP_RECEIVED = 'ship_received';    // 已收货

    public const ORDER_STATUS_REFUND_PENDING = 'refund_pending';    // 未退款
    public const ORDER_STATUS_REFUND_APPLIED = 'refund_applied';    // 已申请退款
    public const ORDER_STATUS_REFUND_PROCESSING = 'refund_processing';  // 退款中
    public const ORDER_STATUS_REFUND_SUCCESS = 'refund_success';    // 退款成功
    public const ORDER_STATUS_REFUND_FAILED = 'refund_failed';  // 退款失败

    public static $refundStatusMap = [
        self::ORDER_STATUS_PAY_CLOSE =>'已关闭',
        self::ORDER_STATUS_PAY_PENDING =>'未支付',
        self::ORDER_STATUS_PAY_SUCCESS =>'已支付',
        self::ORDER_STATUS_REFUND_PENDING => '未退款',
        self::ORDER_STATUS_REFUND_APPLIED => '已申请退款',
        self::ORDER_STATUS_REFUND_PROCESSING => '退款中',
        self::ORDER_STATUS_REFUND_SUCCESS => '退款成功',
        self::ORDER_STATUS_REFUND_FAILED => '退款失败',
        self::ORDER_STATUS_SHIP_PENDING => '未发货',
        self::ORDER_STATUS_SHIP_DELIVERED => '已发货',
        self::ORDER_STATUS_SHIP_RECEIVED => '已收货',
    ];


    public $table = 'orders';

//    public $fillable = [
//
//    ];

    public $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->using(OrderProduct::class)
            ->withPivot(['quantity', 'sku'])->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function orderNumber(){
        return hash('sha256', microtime());
    }

    public function productsCount(){
        return $this->products->count();
    }

    public function totalProductsPrice()
    {
        $Totals = 0;
        foreach ($this->products as $product) {
            $total = $product->price * $product->pivot->quantity;
            $Totals += $total;
        }

        return floor($Totals * 100) / 100;
    }

    public function orderStatusText(string $type)
    {
        return static::$refundStatusMap[$type];
    }

    public function statusText()
    {
        return static::$refundStatusMap[$this->order_status];
    }


}
