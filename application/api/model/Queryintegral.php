<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 10:22
 */

namespace app\api\model;
use think\Db;
use think\Model;

class Queryintegral extends Model{

    /**
     * @param $member_id
     * @return mixed
     */

    /*function query_integral($member_id){

            $data=Db::table('get_integral')->where('member_id',$member_id)->select();

        if(empty($data)){
                $array["type"]=0;
                $array["lang"]=lang('error');
            return $array;
            }else{
                $array["type"]=1;
                $array["lang"]=lang('success');
                $array["data"]=$data;
            return $array;
            }


    }*/

    function query_integral($member_id,$startlimit,$endlimit){

        $data=Db::table('get_integral')
            ->field('id,time,get,number,member_id,img,spec')
            ->where('member_id',$member_id)
            ->limit($startlimit,$endlimit)
            ->order("time","desc")
            ->select();

        if(empty($data)){
            $array["type"]=0;
            $array["lang"]=lang('error');
            return $array;
        }else{
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array["data"]=$data;
            return $array;
        }


    }



}