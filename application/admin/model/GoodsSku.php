<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23
 * Time: 13:31
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class GoodsSku extends Model
{
    function having($id)
    {
        $has = Db::table('goods_sku')->where('spu_id',$id)->find();
        $data=['spu_id'=>$id];
        if($has=='NULL'){
            $have = Db::table('goods_sku')->insert($data);
        }else{
            $have = Db::table('goods_sku')->where('spu_id',$id)->find();
        }
        return $have;
    }

    function sel($spuid)
    {
        //$sku = $this->where('id',$id)->find();
        $sku = Db::table('goods_sku')->where(['spu_id'=>$spuid,"delete"=>0])->select();
        return $sku;
    }

    function adds(){

    }

    function deleajax($id)
    {
        $data = ['delete'=>'1'];
        $deajax = Db::table('goods_sku')->where('id',$id)->update($data);
        return $deajax;
    }
    function deleaj($id)
    {
        $data = ['delete'=>'1'];
        $deajax = Db::table('goods_sku')->where('spu_id',$id)->update($data);
        return $deajax;
    }
}