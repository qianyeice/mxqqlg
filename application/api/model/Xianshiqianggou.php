<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/13 0013
 * Time: 16:53
 */

namespace app\api\model;


use think\Model;
use think\Db;
class Xianshiqianggou extends Model {
    public function index($pid){
//        $data=$this->where("id",$pid)->select();
        $data=$this->select();
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]="success";
        }else{
            $array["type"]=0;
            $array["lang"]="error";
        }
        $array["data"]=$data;
        return $array;
    }
    public function shi($pid){
        $data=Db::name('promotion_commodity')->field("id")
            ->where("panduan","1")
            ->where("is_display","1")
//           ->where("start_time","<",time())
//            ->where("end_time",">",time())
            ->select();
        $data=$this
            ->field('name,price')
            ->where("goods_id",$pid)
            ->where('id',$data[0]['id'])
            ->select();
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]="success";
        }else{
            $array["type"]=0;
            $array["lang"]="error";
        }
        $array["data"]=$data;
        return $array;
    }
    // 现实抢购详情内容 易恒辉7月9日改
    public function xian($id){
        $data=$this
            ->where('id',$id)
            -> select();
        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]="success";
            $array["data"]=$data;
        }else{
            $array["type"]=0;
            $array["lang"]="error";
            $array["data"]='';
        }


        return $array;
    }

    public function news($id){
        $data=Db::name('goods_spu')->field("type")
            ->where("id",$id)
            ->select();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]="success";
        }else{
            $array["type"]=0;
            $array["lang"]="error";
        }
        $array["data"]=$data;
        return $array;
    }
}