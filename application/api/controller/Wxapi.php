<?php
/**
 * 微信链接API
 *张关燚
 * 2018.3.22 14.23
 * 微信模板发送
 * 微信网页授权获取用户信息
*/
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/21
 * Time: 16:58
 */
namespace app\api\controller;
use api\WxLogin;
use apiController\apiController;
use https\curl;
use api;

class Wxapi extends apiController {
    //获取微信accesstoken
    public function getAccessToken(){
        $a=new WxLogin();
        $access_token=$a->get_access_token();
        return $access_token;
    }
    //获取用户信息
   public function getWebPageAuthorizationCode(){
       $a=new WxLogin();
       $code=input('code');
       if(isset($code)){
           $b=$a->get_user_information($code);
       }else{
           $b=$a->get_user_information();
       }
       return json_decode($b,true);
   }
    //消息推送
    public function getTemplatemessage(){
        $a = new api\Message();
        $b=$a->message(3379,'fxdz','1','1','1','1');
        return $b;
    }
    function GetSignPackage(){
        $data = config('weixinz');
        $jsapiTicket = $this->getJsApiTicket();
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=".$jsapiTicket['data']."&noncestr=$nonceStr&timestamp=$timestamp&url=";
//        $string = "jsapi_ticket=".$jsapiTicket['data']."&noncestr=$nonceStr&timestamp=$timestamp&url=";
        $signature = sha1($string);
        $signPackage = array(
            "appId"     => $data['appid'],
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $JsApiTicket = cache('JsApiTicket');
        $returndata=[];
        if (!$JsApiTicket) {
            $a=new WxLogin();
            $access_token=$a->get_access_token();
            if($access_token['type']==1){
                $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token['data']."&type=jsapi";
                $res=curl::curl_get_https($url);
                $res = json_decode($res,true);
                if($res['errcode']!=0){
                    $returndata['type']=0;
                    $returndata['data']='JsApiTicket获取失败';
                }else{
                    cache('JsApiTicket',$res['ticket'],7200);
                    $returndata['type']=1;
                    $returndata['data']=$res['ticket'];
                }
            }else{
                $returndata['type']=0;
                $returndata['data']='JsApiTicket获取失败';
            }
        }else{
            $returndata['type']=1;
            $returndata['data']=cache('JsApiTicket');
        }
        return  $returndata;
    }
}