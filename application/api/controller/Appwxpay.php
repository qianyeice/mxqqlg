<?php

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Appwechatpay;
use app\api\model\Member;
use think\Db;
use weChatPay\Pay;
use weChatPay\weChatPayfun;
use weChatPay\yhpay;


class Appwxpay extends apiController
{
    /**
     * APP微信支付接口   微信app支付不支持真机调试！！！！
     * 龙云飞
     */
    public function wxPay()
    {
        include_once './static/appWxPay/index.php';
        header("Access-Control-Allow-Origin: ityangs.net");
        $sn=input('sn');
        $orderamount = Db::table("order")->where("sn", $sn)->field("paid_amount")->select();
        $ordertotal = $orderamount[0]["paid_amount"] * 100;
        $data= appWxPay($ordertotal);
       file_put_contents('../kk',"\r\n".json_encode($data),FILE_APPEND);
        return $data;

//         允许 ityangs.net 发起的跨域请求

//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *
//        header('Access-Control-Allow-Origin:*');

//        $ordermsg=new Appwechatpay();
//        $canshu=new weChatPayfun();
//        $sn=input("sn");
////        $sn="2018062910050101";
//        $ip=$canshu->getIp();
//       // $ip="127.0.0.1";
//        $noncestr=$canshu->getNonceStr();
////        $noncestr="jntf2fc50xmsynycs0l2ogl8zch7fqdv";
//        $app=config("app");
//        $appid=$app["appid"];
//        $mchid=$app["mchid"];
//        $key=$app["key"];
//        $data=$ordermsg->getOrderIdBysn($sn,$ip,$noncestr,$appid,$mchid,$key);
//        return $data;

    }

//    app微信充值接口
    public function wxrecharge()
    {
        include_once './static/appWxPay/index.php';
        header("Access-Control-Allow-Origin: ityangs.net");
        $money=input('money');
        $data = appWxPay($money);
//        file_put_contents('../kk',"\r\n".json_encode($data),FILE_APPEND);
        return $data;
    }





    public function getweixinzhifudata(){
//       $return_code=
//        return $return_code;
    }

    //获取订单价格,用户openId
    public function or_op($sn){
       $or_op=Db::name('order')->alias('o')->join('member m','m.id = o.buyer_id')
            ->field("o.paid_amount,m.openid,o.sn")->where('o.sn',$sn)->find();
        return $or_op;
    }

    /**
     * 易恒辉写的
     * @return array
     */
    public function or_sn()
    {
        $sn = input('sn');
        if (!is_null($sn)) {
            $res = new Appwechatpay();
            $data = $res->or_sn($sn);
            $this->apiJournal($data["type"], $data["lang"], $data["data"]);//日志
            return $this->apiReturn($data["type"], $data["lang"], $data["data"]);//返回格式
        } else {
            return $this->apiReturn(0, lang('faileds'));//返回格式
        }
    }
    /*
     * 提现
     * 冯云祥
     */
    public function tixian(){
        $id=input("id");//用户id
        $money=input("money");//钱
        $Member=new Member();
        $openid=$Member->member_openid($id);
        $openid=$openid['data']['openid'];
        $class=new yhpay();
//        $openid='ogbUgws3aFCIyJyq1WfdfnDh0lpQ1';//用户openid  加了个1
//        $money=100;//100等于1元
        $weixin=config('weixinz');
        $appid=$weixin['appid'];//商户appid
        $mch_id=$weixin['mchid'];//商户id
        $key=$weixin['key'];//密钥
        $data=$class->paytowx($openid,$money,$appid,$mch_id,$key);
        return $data;
    }


    /*
     * 微信公众号支付
     */
    public function zhifu(){
        $or_op=input();
        $proo['openId']=$or_op['openid'];
        $proo['orderSn']=$or_op['sn'];
        $proo['fee']=$or_op['paid_amount'];
        $weixin=config('weixinz');
        $data['data']["appID"]=$weixin['appid'];//商户appid
        $data['data']["mch_id"]=$weixin['mchid'];//商户id
        $data['data']["key"]=$weixin['key'];//密钥
        $data["data"]["Appsecret"]=$weixin['appsecret'];
        $notify_url='http://api.mxqqlg.com/?s=api/Appwxpay/zhifu';
        $class=new Pay($data,$notify_url);
        $data=$class->toPay($proo);
        return $data;
    }

    //充值
    public function chongzhi(){
        $arr = [
            'id'=>input("id"),
            'money'=>input("money"),
        ];
        $proo['openId']=Db::table('member')->where('id',$arr['id'])->value('openid');//用户id
        $proo['fee']=$arr['money'];//钱
        $weixin=config('weixinz');
        $data['data']["appID"]=$weixin['appid'];//商户appid
        $data['data']["mch_id"]=$weixin['mchid'];//商户id
        $data['data']["key"]=$weixin['key'];//密钥
        $data["data"]["Appsecret"]=$weixin['appsecret'];
        $notify_url='http://api.mxqqlg.com/?s=api/Appwxpay/chongzhi';
        $class=new Pay($data,$notify_url);
        $data=$class->toPay($proo);
        return $data;

    }
}


