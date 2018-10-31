<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/22
 * Time: 9:29
 */

namespace app\api\controller;

use apiController\apiController;
use aliyunShortmessage\api_demo\SmsDemo;
use app\api\model\Member;
use think\Cookie;
use think\Session;

class MobileLogin extends apiController
{
    /**
     *  app手机短信登录
     * @param $member_id 获取用户ID  $model $rlst
     * @return 返回查询后结果
     * 冯云祥
     * 2018-3-22 9：20
     */
    public function mobile_login()
    {
        $phone = input('phone');//手机号码
        $message = input('message');//验证码
        $pid = input('pid');
//        return $phone."+".$message."+".$pid;
//        $a = new Session();
//        $fason = $a->get($phone);
//        return $phone."+++".$message;
        $fason=cache(md5($phone));

        $a = new Member();
        $b = $a->MobileLogin($phone, md5($message), $fason,$pid);
        if ($b["lang"] == lang('success')) {
//            $_COOKIE['duanxin'];
            $a = new Session();
            $a->set($phone,null);
        }
        else if($b["lang"]==lang('duanxin2')){
            $a=new Session();
            $a->clear($phone);
        }else if($b["lang"]==lang('duanxin3')){
            $a=new Session();
            $a->clear($phone);
        }
        $this->apiJournal($b["type"], $b["lang"], $b["data"]);
        return $this->apiReturn($b["type"], $b["lang"], $b["data"]);
////        return 1;
    }

//发送短信
    public function fa()
    {
        $phone = input('phone');
//        $phone='15884424437';
        //生成短信
        $rand = rand(1000, 9999);
        //   $rand = 1234;
        $data = new SmsDemo();
        $data = $data::sendSms($phone, $rand);
//        return $rand;
//        var_dump($data);
        if ($data->Code == 'OK') {
            cache(md5($phone),md5($rand),1800);
            $this->apiJournal(1, lang('duanxin1'),$rand);
            return $this->apiReturn(1,lang('duanxin1'),$rand);
        } elseif ($data->Code == 'isv.BUSINESS_LIMIT_CONTROL') {
//            return lang("duanxin1");
            $this->apiJournal(0, lang('duanxin4'),lang('duanxinduo'));
            return $this->apiReturn(0, lang('duanxin4'),lang('duanxinduo'));
        }else{
            $this->apiJournal(0, lang('duanxin4'),lang('duanxincuo'));
            return $this->apiReturn(0, lang('duanxin4'),lang('duanxincuo'));
        }
    }

//注册用户
    public function register()
    {
        $phone = input('phone');
        $message = input('message');
//        $a = new Session();
//        $fason = $a->get($phone);
        $fason=cache(md5($phone));
        $a = new Member();
        $b = $a->register($phone, md5($message), $fason);
        if ($b["lang"] == lang('zccg')) {
            $a = new Session();
//            $a->clear($phone);
            $a->set($phone, null);
        }
        $this->apiJournal($b["type"], $b["lang"], $b["data"]);
        return $this->apiReturn($b["type"], $b["lang"], $b["data"]);
    }

    //微信手机绑定
    public function shouojib()
    {
        $pid = input('pid');
        $phone = input("phone");
        $img = input("img");
        $openid = input('openid');
        $nickname = input('nickname');

        $a = new Member();
        $data = $a->bangd($phone, $img, $openid, $nickname,$pid);
        return $this->apiReturn($data["type"], $data["lang"], $data["data"]);
    }
}