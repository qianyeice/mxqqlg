<?php
/**
 *
 * Created by PhpStorm.
 * User: 谢岸霖
 * Date: 2018/3/24
 * Time: 11:00
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Memberselect;

class Personalinformation extends apiController{
    /**
     *
     * Created by PhpStorm.
     * User: 谢岸霖
     * Date: 2018/3/24
     * Time: 14:00
     * 我的资料页面个人信息接口
     * $openid为用户登录微信授权成功后的openid
     */
    function personal(){
        $userId = input("post.userID");
        $data=new Memberselect();
        $openid='ooFR60_K1noNDRsqw3fCuMDoGUfE';
        $data=$data->memberquery($openid);
        return $this->apiReturn(count($data),lang('fail'),$data);
    }
    /**
     *
     * Created by PhpStorm.
     * User: 谢岸霖
     * Date: 2018/3/24
     * Time: 14:00
     * 我的二维码页面个人信息接口
     * $openid为用户登录微信授权成功后的openid
     */
    function mytwocode(){
        $data=new Memberselect();
        $openid='ooFR60_K1noNDRsqw3fCuMDoGUfE';
        $data=$data->membertwo($openid);
        return $this->apiReturn(count($data),lang('fail'),$data);
    }
}