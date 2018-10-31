<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/7
 * Time: 10:25
 */
namespace  app\api\model;
use think\Model;
use think\Db;

class Get_unsettled extends Model{
    function  Unsett($member_id){
        $test = array(
            "member_id"=>$member_id,
            "type"=>0
        );
        $data =$this->where($test)->select();
        for($i=0;$i<count($data);$i++){
            $data[$i]['time']=date('Y-m-d H:i:s', $data[$i]['time']);
        }

        if(empty($data[0])) {
            //  说明无数据，无订单
            $array["type"] = 0;
            $array["lang"] = "error";
            $array["data"] = $data;
        }else{
            $array["type"]=1;
            $array["lang"]="success";
            $array["data"] = $data;
        }
        return $array;
    }

    function Record_income($member_id){
        $data =$this->where("member_id",$member_id)->select();
        for($i=0;$i<count($data);$i++){
            $data[$i]['time']= date('Y-m-d H:i:s', $data[$i]['time']);
        }
        if(empty($data[0])) {
            //  说明无数据，无订单
            $array["type"] = 0;
            $array["lang"] = "error";
            $array["data"] = [];
        }else{
            $array["type"]=1;
            $array["lang"]="success";
            $array["data"] = $data;
        }
        return $array;
    }
}