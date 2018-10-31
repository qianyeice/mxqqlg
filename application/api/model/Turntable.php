<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 10:19
 */

namespace app\api\model;
use think\Model;

class Turntable extends Model
{
    /**
     * 查询大转盘的奖品详情
     * 陈昌海
     * 18.3.22 15.14
     * @param $lottery_id:活动id；$id：奖品id
     * @return
     */
    function prize($lottery_id,$id)
    {
        $details = $this
            ->field('lottery_id,activity_name,id,type,prize_name,remarks,probability,number,frequeny')
            ->where('lottery_id',$lottery_id)
            ->where('id',$id)
            ->find();

        $array=array();
        if(count($details)>0){
            $array["type"]=1;
            $array["lang"]="success";
            $array["data"]=$details;
        }else{
            $array["type"]=0;
            $array["lang"]="faileds";
            $array["data"]=count($details);
        }
        return $array;
    }

}