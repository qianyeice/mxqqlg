<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\27 0027
 * Time: 17:34
 */
namespace app\api\model;
use think\Db;

Class Registered{
    function mode($mobile,$parent_id,$openid,$username,$avatar,$time){
        $data=Db::name('member')->insert(
            [
                'mobile' => $mobile,
                'username' => $username,
                'avatar'=>$avatar,
                'login_time'=>$time,
                'parent_id'=>$parent_id,
                'Sign_time'=>$time,
                'openid'=>$openid,
                'register_time'=>$time,
            ]
            , true);
        if ($data) {
            $array["type"] = 1;
            $array["lang"] = 'Add_class';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'Add_success';
        }
        $array["data"] = $data;
        return $array;
    }
}