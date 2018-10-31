<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\27 0027
 * Time: 14:34
 */
namespace Registeredusers;
use app\api\controller\Wxapi;
Class Registeredusers{
    /*
     * 注册用户接口获取用户信息
     * Time: 2018\3\27  15:20 name：白锦国
     */
    function Method(){
        $UserInformation=new Wxapi();
        $Information=$UserInformation->getUserInformation();
        return $Information;
    }
}