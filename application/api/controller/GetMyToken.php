<?php
namespace app\api\controller;
use app\api\model\Api_user;
use https\curl;
Class GetMyToken{
    /*
     * @param $appid:用户appid
     * @param $appsecret:用户appsecret
     * 获取我们的Token（获取后才能调接口）
     * Time: 2018\4\2  10:05 name：冯云祥
     */
    public function index(){
//        $appid=input('post.appid');
//        $appsecret=input('post.appsecret');
        $appid='fengyunxiang';
        $appsecret='fyx123';
        $MyToken=new Api_user();
        $Token=$MyToken->getMyToken($appid,$appsecret);
        return $Token;
    }
}