<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/26 0026
 * Time: 16:00
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\Member;
use weChatPay\yhpay;


class Pay extends apiController{
    public function apptowx(){
        $member_id=input("member_id");
        $money=input("money")*100;
        $mm=new Member();
        $arr=$mm->getOpenid($member_id);
        $app=config("app");
        $openid=$arr["openid"];
        $re=new yhpay();
        $result=$re->paytowx(   $openid,$money,$app["appid"],$app["mchid"],$app["key"]);
        $array=array();
        if($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS'){
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array["data"]=$result;
        }else{
            $array["type"]=0;
            $array["lang"]=$result['err_code_des'];
            $array["data"]=array();
        }
        return $array;
    }
}