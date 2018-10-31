<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 11:06
 */

namespace  app\api\model;
use https\curl;
use think\Model;
use think\Db;

class Details extends Model{

    /**
     * @param $order_id 订单ID
     * @param $goodid 商品ID
     * @param $delivery_sn 运单号
     * @return string
     */
    function logistics_details($order_id){

        $data=Db::table('order_delivery')->where('order_id',$order_id)->select();

        if(empty($data)){
            $array["type"]=0;
            $array["lang"]=lang('error');
            $array["data"]=$data;
            return $array;
        }else{
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array["data"]=$data;
            return $array;
        }
    }


    public function cha($no,$com){
        $a=new curl();
        $data=[
            'com'=>$com,//快递公司
            'no'=>$no,//订单号
            'key'=>'4a02ecc6cd69a3d865187b4029d1d163',
        ];
        $b=$a->curl_post_https('http://v.juhe.cn/exp/index',$data);
        return $b;
    }
}