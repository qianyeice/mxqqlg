<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 16:55
 */
namespace app\api\model;
use think\Model;
use think\Db;
class Kucun extends Model{
    /**
     * 商品库存
     * 冯云祥 2018-6-20 10：09
     * @param $spu_id商品id
     * @return array 返回数据
     */
    function index($spu_id){
        $data=Db::name("goods_sku")->field("number")->where("spu_id",$spu_id)->select();
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]='success';
            $gong=0;
            foreach ($data as $v){
                $gong=$v['number']+$gong;
            }
            $array["data"]=$gong;
        }else{
            $array["type"]=0;
            $array["lang"]='no_number';
            $array["data"]=$data;
        }
//        $array["data"]=$data->toArray();
        return $array;
    }

}