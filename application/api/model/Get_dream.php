<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/3/31
 * Time: 15:36
 */
namespace app\api\model;
use think\Model;

class Get_dream extends Model{
    /**
     * 梦想币日志
     * time:2018-3-29 15:43
     * author:李磊
     * @param $id 用户id
     * @return $array 返回数据
     */

    public function dreammoney($id){
        $data=$this
//            ->field('number')
            ->query("select a.time,a.get,a.number,b.sku_name,b.thumb,b.shop_price from get_dream as a JOIN goods_sku as b on b.id=a.sku_id where a.member_id=".$id);
//            ->where('time','>',config('start_time'))
//            ->where('time','<',config('end_time'))
//            ->sum('number');

        $array=array();
        //        判定是否有数据
        if(count($data)>0){
//            梦想币获得明细
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