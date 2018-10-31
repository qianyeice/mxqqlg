<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 9:36
 */
namespace app\api\model;
use think\Db;
use think\Model;

class DistrbutionLog extends Model{
    /**
     * 今天佣金总数
     * 程建 2018-3-27 9:53
     * @param $id 用户id
     * @return array 返回总佣金
     */
//    function day_distrbution($userId){
//        $data=$this->field('money')
//            ->where('member_id',$userId)
//            ->where('time','>',config('start_time'))
//            ->where('time','<',config('end_time'))
//            ->sum('money');
//        $array=array();
////        判定是否有数据
//        if(count($data)>0){
////            计算今日总佣金
//            $array["type"]=1;
//            $array["lang"]='success';
//        }else{
//            $array["type"]=0;
//            $array["lang"]='noData';
//        }
//        $array["data"]=$data;
//        return $array;
//    }
    function day_distrbution($userId){
        $data=Db::table('get_distribution')->field('money')
            ->where('member_id',$userId)
            ->where('time','>',config('start_time'))
            ->where('time','<',config('end_time'))
            ->sum('money');
        $array=array();
//        判定是否有数据
        if(count($data)>0){
//            计算今日总佣金
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