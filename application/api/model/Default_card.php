<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 13:32
 */

namespace  app\api\model;
use think\Model;
use think\Db;

class Default_card extends Model{
    /**
     * @param $mid
     * @return mixed
     */
    function card($mid){

        $default["mid"] = $mid;

        $default["id_default"] = 1;

        $data=Db::table('member_bank')->where($default)->select();
        if(empty($data)){
            return "Sorry,You have not set the default card";
        }else{
            return $data;
        }
    }

    /**
     *
     * 邓强
     * @param $bank_no
     * @param $id
     * @return string
     */
    function upbank($bank_no,$id){
        $default["bank_no"] = $bank_no;
        $default["mid"]= $id;
        $date["id_default"]=1;
            $data=Db::name('member_bank')->where($default)->update($date);
        if(empty($data)){
            $array["type"]=0;
            $array["lang"]=lang('error');
            $array["data"]=$data;
            return $array;
        }else{
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array["data"]=$data;
            return $array;
        }

        }
}