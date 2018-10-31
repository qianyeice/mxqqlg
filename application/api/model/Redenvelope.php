<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/17
 * Time: 15:32
 */
namespace app\api\model;

use think\Model;

class Redenvelope extends Model
{
    /**
     * 首页现金红包
     * @param $merberId
     * @return array
     */
    public function syCash($merberId){

        $data=[
            "membertx_zi"=> "已完成购物的下级用户的头像",
            "memberId_zi"=> "已完成购物的下级用户的名称",
        ];
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"]=$data;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'notuser';
        }
        return $array;
    }
}