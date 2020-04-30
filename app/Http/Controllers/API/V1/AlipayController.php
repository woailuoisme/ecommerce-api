<?php
namespace App\Http\Controllers\API\V1;
use App\Http\Controllers\AppBaseController;
use Omnipay\Alipay\Responses\AopTradePagePayResponse;
use Omnipay\Omnipay;
class AlipayController extends AppBaseController
{
    public function pay()
    {
        $gateway = Omnipay::create('Alipay_AopPage');
        $gateway->setSignType('RSA2'); //RSA/RSA2
        $gateway->setAppId('the_app_id');
        $gateway->setPrivateKey('the_app_private_key');
        $gateway->setAlipayPublicKey('the_alipay_public_key');
        $gateway->setReturnUrl('https://www.example.com/return');
        $gateway->setNotifyUrl('https://www.example.com/notify');
        $request = $gateway->purchase();
        $request->setBizContent([
            'out_trade_no' => date('YmdHis').random_int(1000, 9999),
            'total_amount' => 0.01,
            'subject'      => 'test',
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ]);
        $request = $gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET)); //Don't use $_REQUEST for may contain $_COOKIE
        try {
            /**
             * @var AopTradePagePayResponse $response
             */
            $response = $request->send();
            dd($response->getData());
            $redirectUrl = $response->getRedirectUrl();
            if ($response->isPaid()) {
                die('success'); //The notify response should be 'success' only
            } else {
                die('fail'); //The notify response
            }
        } catch (\Exception $e) {
            dd('fail');
        }
    }
}