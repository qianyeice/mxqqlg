<?php
namespace app\api\model;
use think\Model;
use think\Db;
class Evaluation extends model{

    public function comm_eval($spu_id){
     $box = $this->where('spu_id',$spu_id)->order("datetime","desc")->field("id,content,datetime,mid,username,avatar")->select();
     //$evaNum = Db::name("comment")->where("spu_id",$spu_id)->count("id");
     $array=array();
        if(count($box) > 0){
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]= $box;
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
            $array["data"]= "";
        }
        return $array;
    }
}