<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/9
 * Time: 16:00
 */

namespace app\api\controller;

class wxPay
{
    public function pay(){
        require_once "./static/php_sdk_v3.0.9/example/WxPay.JsApiPay.php";
//        new \JsApiPay();
    }
}