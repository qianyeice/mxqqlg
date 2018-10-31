<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 15:01
 */
namespace  app\api\model;
use think\Model;
use think\Db;

class Confirmation_receipt extends Model{
    /**
     * @param $order_id
     * @param $goodid
     * @return mixed
     */
    function receipt($sn){
        $teael["sn"] = $sn;
        //修改确认收货（order_sku）
        $data=Db::table('order')->where($teael)->update(['status' => 3]);
        if($data>0){
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array['data']='1';
//            $this->status($order_id);
        }else{
            $array["type"]=0;
            $array["lang"]=lang('error');
            $array['data']='0';
        }
        return $array;
    }




    function changes($sn){
        $teael["sn"] = $sn;
        //修改确认收货（order_sku）
        $data=Db::table('order')->where($teael)->update(['status' => 1]);
        if($data>0){
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array['data']='1';
//            $this->status($order_id);
        }else{
            $array["type"]=0;
            $array["lang"]=lang('error');
            $array['data']='0';
        }
        return $array;
    }


//    function status($order_id){
//
//        //修改订单表的确认状态（order）
//        $data_a=Db::table('order_sku')->where("order_id",$order_id)->select();
//        $count_a = count($data_a);
//        $array_a = array(
//            "order_id"=>$order_id,
//            "is_queren"=>1
//        );
//        $data_b=Db::table('order_sku')->where($array_a)->select();
//        $count_b = count($data_b);
//
//        //对order的确认做修改
//        if($count_a==$count_b){
//            Db::table('order')->where("id",$order_id)->update(['confirm_status' => 2]);
//        }else if($count_a>$count_b){
//            Db::table('order')->where("id",$order_id)->update(['confirm_status' => 1]);
//        }
//
//        Db::table('order')->where("id",$order_id)->update(['status' => 3]);
//    }
}

