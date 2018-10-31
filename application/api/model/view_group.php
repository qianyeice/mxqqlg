<?php
namespace app\api\model;

use think\Model;
use think\Db;
class view_group extends Model{

    /***
     * @param $mid
     * @return array
     * 用户vip等级 + 进度值
     */

    function draw($mid){
        $res = $this->where('mid',$mid)->select();
        $array=array();
        if(count($res)>0){
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$res;
        return $array;

    }

    /**
     * @param $mid 参数
     * @param $money 参数
     * @return array 返回值
     */
    function Withdrawing($mid,$money){
        $res = Db::name("member")->where("id",$mid)->field("money")->select();
        $ras=$res[0]["money"]-$money;
        $a= date('y-m-d h:i:s',time());
        Db::name('member')->where('id',$mid)->update(['money'=>$ras]);
        $date=["mid"=>$mid,"amount"=>$money,"applytime"=>$a,"type"=>2,"wtype"=>0];
        $rws=Db::name('Withdraw')->insert($date);
        $array=array();
        if($rws){
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=1;
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
            $array["data"]=0;
        }
        return $array;
    }


}