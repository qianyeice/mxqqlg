<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 11:06
 */

namespace  app\api\model;
use think\Model;
use think\Db;

class Logistics extends Model{

    /***
     * @param $order_sn
     * @param $buyer_id
     * @param $delivery_sn
     * @return mixed
     */
    function courier_logistics($sn,$buyer_id,$delivery_sn){


        $data=$this->where(array(
                'sn' => $sn,
                'buyer_id'=>$buyer_id,
                'delivery_sn'=> $delivery_sn
            ))
            ->order('time desc,remark')
            ->select();

        if(count($data) > 0){
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array["data"]=$data;
            return $array;
        }else{
            $array["type"]=0;
            $array["lang"]=lang('error');
            $array["data"]=$data;
            return $array;
        }
    }

}