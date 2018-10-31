<?php
/**
 * 订单状态详情页面接口
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/31
 * Time: 11:26
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\Order_sku_gid;

class Orderstatus extends apiController{
    function Order(){
        $gid=input('post.gid');
        $data=new Order_sku_gid();
        $array = $data->status($gid);
        return $this->apiReturn($array["type"],$array["lang"],$array["data"]);
    }
}