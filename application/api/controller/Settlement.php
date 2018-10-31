<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 16:34
 */

namespace app\api\controller;
use apiController\apiController;
use \app\api\model\GetDistribution;

class Settlement extends apiController
{
    /**
     * 我的收入根据用户id判断未结算、已结算、退单；
     * author:冯云祥
     * @param $id 传入用户id;   $type=0:未结算；1:已结算；2:退单；
     */
    public function distribution()
    {
        $id = input('id');
        $type = input('type');
        $dis = new GetDistribution();
        $apple = $dis->distribution($id,$type);
        return $this->apiReturn($apple["type"],$apple["lang"],$apple["data"]);
    }


}