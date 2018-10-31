<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12 0012
 * Time: 16:19
 */

namespace app\api\model;
use think\Model;
use think\Db;

class Promotion_commodity extends Model {
//接口已确认，app+微信，7月17
    public function index(){
        $data=$this->field("id,end_time,start_time,img")
            ->where("panduan","1")
            ->where("is_display","1")
            ->where("start_time","<",time())
            ->where("end_time",">",time())
            ->select();

        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]="success";
        }else{
            $array["type"]=0;
            $array["lang"]="noData";
        }
        $array["data"]=$data;
        return $array;
    }
    public function shopping($id){
        $data=$this->field("id")
            ->where("panduan","1")
            ->where("is_display","1")
            ->select();
        $con=Db::name('promotion_commodity_relation')
            ->where('promotion_commodity_id',$data[0]['id'])
            ->where('spu_id',$id)
            //            ->where("start_time","<",time())
//            ->where("end_time",">",time())
            ->find();
        $array=array();
        if(count($con)>0){
            $array["type"]=1;
            $array["lang"]="success";
        }else{
            $array["type"]=0;
            $array["lang"]="noData";
        }
        $array["data"]=$con;
        return $array;
    }
}