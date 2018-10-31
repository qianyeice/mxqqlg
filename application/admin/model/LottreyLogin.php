<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 11:49
 */
namespace app\admin\model;
use think\Db;
use think\Model;

class LottreyLogin extends Model{
    /**
     * 抽奖活动中奖纪录
     * name 李磊
     * time  2018-04-27 14:46
     */
//    public function nub()
//    {
//        $data=$this->field("id")->select();
//        return count($data->toArray());
//    }
    public function Journal($start,$limit){
        return Db::table('LottreyLogin')->select();
//         $data=$this->select();
//        $data=$this
//            ->field("id,name,grant_type,time,prize_type,member_id,mid,username,mobile")
//            ->where("grant_type","1")
//            ->limit($start,$limit)
//            ->select();

//        if(count($data)>0){
//            return $data;
//        }else{
//            return false;
//        }

    }
}