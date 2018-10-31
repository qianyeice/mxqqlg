<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/8
 * Time: 17:49
 */
namespace app\api\model;
use think\Db;
use think\Model;
class More_classification extends Model{
    /**
     * @param $id
     * @return mixed
     */

//    接口已确认，app，微信，7月17
    function category($id){
        if(empty($id)){
            $data = Db::table('category')
                ->where("parent_id","0")
                ->where("status","=","1")
                ->field("name,id,parent_id")
                ->cache(7200)
                ->select();
            if(empty($data)){
                $array["type"]=0;
                $array["lang"]='error';
            }else{
                $array["type"]=1;
                $array["lang"]='success';
            }
            $array["data"]=$data;
        }else{
            $data = Db::table('category')->where("parent_id",$id)->field("name,id,parent_id")->select();
            if(empty($data)){
                $array["type"]=0;
                $array["lang"]='error';
            }else{
                $array["type"]=1;
                $array["lang"]='success';
            }
            $array["data"]=$data;
        }
        return $array;
    }

}