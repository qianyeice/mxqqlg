<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/7
 * Time: 14:41
 */
namespace app\api\controller;

use apiController\apiController;
use app\api\model\Get_unsettled;

class Recordincome extends apiController{
    function tled(){
        $member_id=input('post.member_id');
        $data=new Get_unsettled();
        $val = $data->Record_income($member_id);
        //        引用apiReturn方法
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);

    }
}