<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/24
 * Time: 16:10
 */
namespace app\api\model;
use think\Model;

class GetIntegral extends Model{
    /**
     * 查询用户积分日志
     * 李磊2018-3-27 16:50
     * @param $id用户id
     * @return array 返回用户积分日志
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function day_integral($userId){
        $data=$this->field('number')
            ->where('member_id',$userId)
            ->where('time','>',config('start_time'))
            ->where('time','<',config('end_time'))
            ->sum('number');
        $array=array();
//        判定是否有数据
        if(count($data)>0){
//            计算今日总积分
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
        $array["data"]=$data;
        return $array;
    }
    function get_integral_Journal(){
        $data=$this->query("get_integral_Journal");
        $array=[];
        if(isset($data[0][0]["type"])){
            $array["type"]=0;
            $array["lang"]="noGoods";
            $array["data"]='';
        }else{
            $array["type"]=1;
            $array["lang"]="success";
            $array["data"]=$data->toArray();
        }
        return $array;
    }
}