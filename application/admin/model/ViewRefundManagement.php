<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/8
 * Time: 16:06
 */

namespace app\admin\model;

use think\Model;

class ViewRefundManagement extends Model
{
    function refund_goods($id)
    {
        $data=$this->where('id',$id)->find();
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]='refund';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$data;
        return $array;
    }
}