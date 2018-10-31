<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 9:28
 */
namespace app\api\model;
use think\Model;

class DividendLog extends Model{
    /**
     * 今日总分红
     * 程建 2018-3-27 9:51
     * @param $id 用户id
     * @return array 返回今天分红和
     */
    function day_dividend($userId){
        $data=$this->field('money')
            ->where('member_id',$userId)
            ->where('time','>',config('start_time'))
            ->where('time','<',config('end_time'))
            ->sum('money');
        $array=array();
//        判定是否有数据
        if(count($data)>0){
//            计算今日总分红
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