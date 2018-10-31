<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/24
 * Time: 10:21
 */
namespace  app\api\model;
use think\Db;
use think\Model;

class DreamRule extends Model{
    /**
     * 会员中心梦想币使用规则
     * 程建 2018-3-24 10:57
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function dreamRule_explain(){

        $data=Db::name("site_dream")
//            ->field('id,dream_day,ordinary_buy,group_buy')
            ->select();

        $array=array();
//        判定是否有数据
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]='success';
        }else{
            $array["type"]=0;
            $array["lang"]='noData';
        }
//        $array["data"]=$data->toArray();
        $array["data"]=$data;
        return $array;
    }
}