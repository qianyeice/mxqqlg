<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/25
 * Time: 15:12
 */
namespace app\api\model;
use think\Db;
use think\Model;
class Proba extends Model{
    /**
     * @param $lottery_id 对应转盘ID
     * @return mixed
     */
    function bility($lottery_id){
        $data = Db::table('lottery_prize')->where("lottery_id",$lottery_id)->where("is_examine",1)->field("name,probability,remarks,img")->select();
        if(empty($data)){
            $array["type"]=0;
            $array["lang"]='noData';
            $array["data"]='';
        }else{
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=$data;
        }
        return $array;
    }
}