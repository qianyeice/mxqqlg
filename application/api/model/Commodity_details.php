<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\24 0024
 * Time: 11:13
 */
namespace app\api\model;
use think\Model;

class Commodity_details extends Model {

    function Goods($member_id,$order){
    $data=$this->query('call Commodity_details('.$member_id.','.$order.')');
    $array=array();
    if(count($data)>0){
        $array["type"]=1;
        $array["lang"]=lang('success');
        $array["data"]=$data[0];
    }else{
        $array["type"]=0;
        $array["lang"]=lang('Evaluatecommodity_Goods');
        $array["data"]=$data;
    }

    return $array;
}




}