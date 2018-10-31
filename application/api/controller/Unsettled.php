<?php
/**
 * 未结算接口
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/6/7
 * Time: 10:17
 */
namespace app\api\controller;

use apiController\apiController;
use app\api\model\Get_unsettled;

class Unsettled extends apiController{
    /**
     * @return array
     */
    function Unset_tled(){
        $member_id=input('post.member_id');
//        $member_id=3157;
        $data=new Get_unsettled();
        $val = $data->Unsett($member_id);
        //        引用apiReturn方法
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);
    }
}