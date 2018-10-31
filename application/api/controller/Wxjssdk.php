<?php

/**
 * Created by PhpStorm.
 * User: xyn
 * Date: 2018/3/14
 * Time: 18:18
 */
namespace app\api\controller;

use api\Jssdk;
use api\WxLogin;
use think\Controller;

class Wxjssdk extends Controller {
    public function index(){
        return view();
    }

    function weixin(){
        $weixin=config('weixinz');
        $appid=$weixin['appid'];
        $appsecret=$weixin['appsecret'];
        $jssdk = new JSSDK($appid, $appsecret);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
        return view();
    }
}