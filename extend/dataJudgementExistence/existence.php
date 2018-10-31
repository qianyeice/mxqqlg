<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/20
 * Time: 11:30
 */
namespace dataJudgementExistence;
class existence{
    /**
     * 提交订单页面判断是否有优惠券数据处理
     * time：18-3-22 11：34
     * author：丁龙
     * @param $data 数据库查询的数量
     * @return array 返回查询结果
     */
    public function HomeCarouselHandle($data){
        //判断是否有数据
        if($data==0){
            $array["type"]=0;
            $array["data"]=$data;
            $array["describe"]='data为拥有的优惠券数量';
            return $array;
        }else{
            $array["type"]=1;
            $array["data"]=$data;
            $array["describe"]='data为拥有的优惠券数量';
            return $array;
        }
    }
}