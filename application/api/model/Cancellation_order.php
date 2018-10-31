<?php
/**
 *  取消订单
 *
 *
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 15:45
 */

namespace  app\api\model;
use think\Model;
use think\Db;

class Cancellation_order extends Model{
    function Cancellationorder($sn){
        $data=Db::table('order')->where("sn",$sn)->update(['hd_type' => 1]);
        $array=[];
        if($data==0){
            $array["type"]=0;
            $array["lang"]=lang('error');
            $array["data"]=$data;
        }else{
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array["data"]=$data;
        }
        return $array;
    }
}