<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\27 0027
 * Time: 14:14
 */
namespace app\api\controller;
use Registeredusers\Registeredusers;
use app\api\model\Registered;
class Registereduser extends Wxapi{
    /*
     * @param $mobile:用户输入手机号
     * @param $openid:用户openid
     * @param $username：用户昵称
     * @param $avatar:头像
     * @param $time:登陆时间，上次签到时间,注册时间
     * @param $parent_id:上级id
     * 注册用户接口
     * Time: 2018\3\27  14:16 name：白锦国
     */
    function Method(){
        $mobile=input('mobile');
        $parent_id=input('parent_id');
        $m_data=new Registered();
        $data=$this->getWebPageAuthorizationCode();
        $datas=json_decode($data,true);
        $openid=$datas['openid'];
        var_dump($openid);
        $username=$datas['nickname'];
        $avatar=$datas['headimgurl'];
        if($openid&&$username&&$avatar&&$mobile!=''){
            $return_data=$m_data->mode($mobile,$parent_id,$openid,$username,$avatar,time());
            return   $return_data;
        }else{
            $array["type"]=0;
            $array["lang"]=lang('faileds');
        }
        return $array;
    }
}