<?php

namespace app\api\model;

use https\curl;
use think\Model;
use think\Db;
use weChatPay\weChatPayfun;

class Appwechatpay extends Model
{
    /**APP微信支付接口
     * @param $sn
     * @param $ip
     * @param $nonceStr
     * @param $appid
     * @param $mchid
     * @param $key
     * @return array
     */
    public function getOrderIdBysn($sn, $ip, $nonceStr, $appid, $mchid, $key)
    {
        $fun = new weChatPayfun();
        $curl = new curl();

//        $orderamount = Db::name("order")->where("sn", $sn)->field("paid_amount")->select();
//        $ordertotal = $orderamount[0]["paid_amount"] * 100;
        $ordertotal = 1;
//        if($orderamount){
        $data = [
            "appid" => $appid,//微信开放平台审核通过的应用APPID
            "mch_id" => $mchid,//微信支付分配的商户号
            "nonce_str" => $nonceStr,//随机字符串，不长于32位
            //"sign"=>"XXX",//签名
            "body" => "梦想全球乐购-商品购买",//商品描述交易字段格式根据不同的应用场景按照以下格式：APP——需传入应用市场上的APP名字-实际商品名称，天天爱消除-游戏充值。
            "out_trade_no" => $sn,//商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*且在同一个商户号下唯一。
            "total_fee" => $ordertotal,//订单总金额，单位为分
            "spbill_create_ip" => $ip,//用户端实际ip
            "notify_url" => "http://api.mxqqlg.com/api/Appwxpay/getweixinzhifudata.html",
            "trade_type" => "APP"
        ];

        $sign = $fun->makeSign($data, $key);
        $data["sign"] = $sign;
        $xml = $fun->arrayToXml($data);
        file_put_contents("kkkkk", "---------------\r\n", FILE_APPEND);
        file_put_contents("kkkkk", $xml, FILE_APPEND);

        $wxreturndata = $curl->curl_post_https("https://api.mch.weixin.qq.com/pay/unifiedorder", $xml);

        file_put_contents("kkkkk", $wxreturndata, FILE_APPEND);
        $wechatData = $fun->xmlToArray($wxreturndata);

        $wxData = [
            "appid" => $wechatData["appid"],
            "partnerid" => $wechatData["mch_id"],
            "prepayid" => $wechatData["prepay_id"],
            "noncestr" => $wechatData["nonce_str"],
            "timestamp" => time(),
            "sign" => $wechatData["sign"],
            "package" => "Sign=WXPay",
        ];
        $sign2 = $fun->makeSign($wxData, $key);
        $wxData["sign"] = $sign2;
//            dump($wxData);
//            exit;
//            var_dump($sign2);
        file_put_contents("kkkkk", "\r\n" . json_encode($wxData), FILE_APPEND);
        return $wxData;
//        }else{
//            echo '订单未找到';
//        }

    }

    public function or_sn($sn)
    {
       $data= Db::table('order')->where('sn',$sn)->select();
        $array = array();
        if ($data) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $data;
        } else {
            $array["type"] = 2;
            $array["lang"] = 'error';
            $array["data"] = $data;
        }
        return $array ;
    }


    //{"appid":"wxfd32690848c7a3e4","partnerid":"1507962261","prepayid":"wxfd32690848c7a3e4","package":"Sign=WXPay","noncestr":"QznKazYZV3tUJYO0","timestamp":1530771319,"sign":"4886D7E4748ABCB2920DE70320DF8143"}
    //
}
