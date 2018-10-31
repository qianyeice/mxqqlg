<?php
/**
 * Created by PhpStorm.
 * User:谢岸霖
 * Date: 2018/3/24
 * Time: 17:06
 */
namespace app\api\controller;
use aliyunShortmessage\api_demo\SmsDemo;
use apiController\apiController;

class Shortmessage extends apiController{
    function sendmessages(){
        $data=new SmsDemo();
        $iphon=input('iphon');
        $random=rand(1000,9999);
        $data=$data::sendSms($iphon,$random);
        return $data;
    }
}