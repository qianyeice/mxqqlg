<?php
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Member;
use weChatPay\Pay;
use app\api\model\Wechat_payment;

class WechatRecharge extends apiController
{
    /**
     * 微信充值
     * mid:用户id ; $body:商品描述 ;$fee:商品价格;
     * User: 冯云祥
     */
    public function index()
    {
        $mid=input('mid');
        $body=input('body');
        $fee=input('fee');
        $weChat=new Wechat_payment();
        $data=$weChat->index();
        if($data['data']!=null){
            $payObj = new Pay($data,config("notify_url"));  //传入配置
            $a=new Member();
            $openid=$a->member_openid($mid);
            $payInfo = array(
                'body'=>$body,//商品描述
                'fee'=>$fee,//商品价格
                'openId'=>$openid['data']['openid'],//用户openId
                "orderSn"=>time(),//商品订单
            );
            $payRes = $payObj->toPay($payInfo);
            dump($payRes);
        }

    }
}