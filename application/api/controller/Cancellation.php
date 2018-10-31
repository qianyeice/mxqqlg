<?php
/**
 *
 *  取消订单
 *
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 15:39
 */
namespace app\api\controller;

use apiController\apiController;
use app\api\model\Cancellation_order;

class Cancellation  extends apiController{
    function order(){
        $sn = input("post.sn");

        if(!is_null($sn)){
            $data=new Cancellation_order();
            $data =  $data->Cancellationorder($sn);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else {
            return $this->apiReturn(0, lang('faileds'));//返回格式
        }
    }

}
