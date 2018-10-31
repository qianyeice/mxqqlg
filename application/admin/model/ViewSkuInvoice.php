<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/8
 * Time: 14:43
 */

namespace app\admin\model;
use think\Model;

class ViewSkuInvoice extends Model
{
    function sku_invoice($id)
    {
      $data=$this->field('id,sn,address_name,address_mobile,print_time,print_type,addre_detail,delivery_name,number,spu_sn,sku_name,spec,sku_amount')
          ->where('id',$id)->select();
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$data;
        return $array;
    }
}