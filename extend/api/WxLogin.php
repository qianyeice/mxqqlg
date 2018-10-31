<?php
namespace  api;
use https\curl;
use think\Session;

class WxLogin{
    /*获取access_token*/
    public function get_access_token()
    {
        $weixin=config('weixinz');
        $appsecret=$weixin['appsecret'];
        $appid=$weixin['appid'];
        $returndata=array();
        if(cache('weixi_api_access_token')){
            $returndata['type']=1;
            $returndata['data']=cache('weixi_api_access_token');
        }else{
            $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret.'';
            $access_token=curl::curl_get_https($url);
            $token=json_decode($access_token,true);
//            var_dump(isset($token['access_token']));
//            var_dump($token);
//            exit;
            if(isset($token['access_token'])){
//               cache(md5($url),$token['access_token'],$token['expires_in']);
                cache('weixi_api_access_token',$token['access_token'],7200);
                $returndata['type']=1;
                $returndata['data']=$token['access_token'];
            }else{
                $returndata['type']=0;
                $returndata['data']='token获取失败';
            }
        }
        return $returndata;
    }
    public function get_openid($code){
        $weixin=config('weixinz');
        $appid=$weixin['appid'];
        $appsecret=$weixin['appsecret'];
        $a=new curl();
        $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $oauth2 = $a->curl_get_https($oauth2Url);
        return $oauth2;
    }
    public function get_user_info_url($access_token,$openid){
        $a=new curl();
        $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userinfo = $a->curl_get_https($get_user_info_url);
        return $userinfo;
    }


    /*
     * 2018-03-30
     * 冯云祥
     * 获取微信用户信息
     * return : 用户openid 用户头像 用户名称....
     */
    public function get_user_information($code=''){
        $weixin=config('weixinz');
        $appid=$weixin['appid'];
        $obj1 = new Session();
        $pid = $obj1->get("pid");
        if(!is_null($code) || !empty($code)){
            //第一步:取全局access_token
            $token=$this->get_access_token();
            $access_token=$token['data'];
            //第二步:取得openid
            $oauth2=$this->get_openid($code);
            //第三步:根据全局access_token和openid查询用户信息
            $openid_array=json_decode($oauth2,true);
            if(isset($openid_array['openid'])){
                $openid = $openid_array['openid'];
                $userinfo=$this->get_user_info_url($access_token,$openid);
                return $userinfo;
            }else{
                $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://cg.mxqqlg.com/index.php&'.$pid.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
                header("Location:".$url);
            }
        }else{
//            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://api.mxqqlg.com/index.php?s=api/Wxapi/getWebPageAuthorizationCode&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://cg.mxqqlg.com/index.php&'.$pid.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            header("Location:".$url);
        }
    }
//    public function get_user_information(){
//        $weixin=config('weixin');
//        $appid=$weixin['appid'];
//        if(isset($_GET["code"])){
//            $code=$_GET["code"];
////           http://api.mxqqlg.com/?s=/api/Wxapi/getWebPageAuthorizationCode
//
//            //第一步:取全局access_token
//            $token=$this->get_access_token();
//            $access_token=$token['data'];
//
//            //第二步:取得openid
//            $oauth2=$this->get_openid($code);
//
//
//            //第三步:根据全局access_token和openid查询用户信息
//            $openid_array=json_decode($oauth2,true);
//            if(isset($openid_array['openid'])){
//                $openid = $openid_array['openid'];
//                $userinfo=$this->get_user_info_url($access_token,$openid);
//                return $userinfo;
//            }else{
//                $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://api.mxqqlg.com/index.php?s=api/Wxapi/getWebPageAuthorizationCode&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
//                header("Location:".$url);
//            }
//        }else{
////           回调域名
////            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://api.mxqqlg.com/index.php?s=api/Wxapi/getWebPageAuthorizationCode&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
//            $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri=http://cg.mxqqlg.com/index.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
//            header("Location:".$url);
//        }
//    }

    //发送模板消息
    public function Send_message($openid,$template_id,$data){
        $a=new curl();
        //第一步:取全局access_token
        $token=$this->get_access_token();
        $access_token=$token['data'];
        $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token.'';
        $data=json_encode($data);
        $fa=$a->curl_post_https($url,$data);
        $this->updata_weixi_api_access_token($fa);
        return $fa;
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


    //生成预支付订单
    public function order(){
        //第一步:取全局access_token
        $token=$this->get_access_token();
        $access_token=$token['data'];

        //第二步:取得openid
//        $oauth2=$this->get_openid($code);

        $url = 'https://api.weixin.qq.com/pay/genprepay?access_token='.$access_token;
    }









}
