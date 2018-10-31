<?php
/**
 *
 *   确认收货
 *
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 14:37
 */
namespace app\api\controller;

use apiController\apiController;
use app\api\model\Confirmation_receipt;

class confirm extends apiController{
    /**
     * @return mixed
     */
    function Collect(){
        $sn = input("sn");
        if(!is_null($sn)){
            $da=new Confirmation_receipt();
            $data =  $da->receipt($sn);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

//    订单评价后更改订单状态
    function change(){
        $sn = input("sn");
        if(!is_null($sn)){
            $da=new Confirmation_receipt();
            $data =  $da->changes($sn);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}