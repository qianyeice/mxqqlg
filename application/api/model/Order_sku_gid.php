<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/31
 * Time: 11:30
 */

namespace  app\api\model;
use think\Model;
use think\Db;

class Order_sku_gid extends Model{
    function status($gid){
        $data = $this->where('goodid',$gid)->field("status")->find();
//        dump(intval($data["status"]));exit;
        if(empty($data[0])){
            //  说明无数据，无订单
            $array["type"]=0;
            $array["lang"]="error";
            $status=[];
        }else{
            //  说明有数据，有订单
            $array["type"]=1;
            $array["lang"]="success";
            if(intval($data["status"])==4){
                $status=["待付款","如果您在24小时内未付款，我们将取消您的订单","付款","取消订单"];
            }else if(intval($data["status"])==3){
                $status=["待评价","购买完成，您可以对商品进行评价","评价","不评价"];
            }else if(intval($data["status"])==2){
                $status=["待收货","商家已经发货","收货","延迟收货"];
            }else if(intval($data["status"])==1){
                $status=["待发货","付款完成，商家准备发货","提醒发货","取消订单"];
            }else{
                $status=[];
            }
        }
        $array["data"]=$status;
        return $array;
    }
}