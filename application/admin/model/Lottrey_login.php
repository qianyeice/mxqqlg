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

class Lottrey_login extends Model{
    /**
     * 抽奖活动中奖纪录
     * name 李磊
     * time  2018-04-27 14:46
     *
     * 吴杰 修改
     * 2018.5.2
     */
//    public function nub()
//    {
//        $data=$this->field("id")->select();
//        return count($data->toArray());
//    }
  public function Journal($start,$limit){

            $data=$this
                ->page($start,$limit)
                ->select();
        return  $data;

    }

    public function Jour(){

        $data=$this->select();
        return  $data;
    }

    public function seler($username,$mobile){
            $data=$this
                ->where("username","$username")
                ->whereOr("mobile","$mobile")
                ->select();
        return  $data;
    }
    public function delet($id){
        return $this->where("member_id",$id)->update(["grant_type"=>1]);
    }
}