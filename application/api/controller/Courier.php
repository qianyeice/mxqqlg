<?php


namespace app\api\controller;
use apiController\apiController;
use app\api\model\Logistics;

class Courier extends apiController{
    /**
     *  快递信息
     * Created by PhpStorm.
     * User: 胡焱
     * Date: 2018/5/9
     * Time: 11:00
     */

    function courier(){
        //订单号
       $sn = input("post.sn");
        //买家id
        $buyer_id = input("post.buyer_id");
        //运单号
        $delivery_sn = input("post.delivery_sn");

        $data = new Logistics();

        $table = $data->courier_logistics($sn, $buyer_id,$delivery_sn);

        return $this->apiReturn($table["type"],$table["lang"],$table["data"]);

    }

}