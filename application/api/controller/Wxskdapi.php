<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/17
* Time: 10:23
*/
namespace app\api\controller;

use apiController\apiController;
use app\api\model\Shopping_Cart;
use app\api\model\Comment_details;
use wxSdk\jssdk;
use https\curl;
class Wxskdapi extends apiController{


    /**
     * 检测access_token  并返回
     * @return mixed
     */
    public function getAccToken(){
        $data=config("weixinz");
        if(!cache("weixi_api_access_token")){
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$data['appid']}&secret=".$data['appsecret'];
            $res=curl::curl_get_https($url);
            $res = json_decode($res,true);
            if (isset($res['access_token'])) {
                $access_token = $res['access_token'];
                cache('weixi_api_access_token',$access_token,7000);
                var_dump($access_token);
                return $access_token;
            }
        }else{
          return  cache("weixi_api_access_token");
        }
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    
    // 获取用户信息
    function userget(){
        $url='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token=$this->getAccToken();
        $error=curl::curl_get_https($url);
        return $this->updata_weixi_api_access_token($error);
    }
    // 手动更新用户 缓存中的token
    function updata_weixi_api_access_token($data){
        $data=json_decode($data,true);
        if(isset($data['errcode'])){
            if($data['errcode']!='0') {
                cache("weixi_api_access_token", false);
            }
        }
    }
}
