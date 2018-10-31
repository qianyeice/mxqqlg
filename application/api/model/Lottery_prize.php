<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 18:11
 */

namespace app\api\model;
use think\Model;

class Lottery_prize extends Model
{
    /**
     * $user_id：用户id,$prize_id：奖品id；
     * time:18-3-29 9:16
     * author:陈昌海
     * @param 传入用户id和奖品id
     * @return $array 返回成功和失败
     */
    function Lottery($user_id,$prize_id)
    {
        $data = $this->query("call lottery_prize('".$user_id."','".$prize_id."')");

        $array=array();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]=lang('faileds');
        }else{
            $array["type"]=0;
            $array["lang"]=lang('success');
        }
        $array["data"]=$data;
        return $array;

    }
}