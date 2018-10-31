<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23
 * Time: 14:02
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class Skugoods extends Model
{
    function sel($id)
    {
        $sku = Db::table('goods_sku')->where('spu_id',$id)->select();

        return $sku;
    }
    function selet($id)
    {
        $sku = Db::table('goods_spu')->where('id',$id)->find();

        return $sku;
    }

    /**
     * 吴杰
     * 商品图片默认主图保存
     * @param $log
     */
    public function sele($id,$log){
        $data=Db::table('goods_spu')->where('id',$id)->update(["imgs"=>$log]);;
        if($data>0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 规格图片保存
     * @param $id 商品id
     * @param $array 下属规格图片信息
      * @return mixed
     */
    public function phot($id, $array){
        $data=Db::table('goods_sku')->where('spu_id',$id)->select();
        $flag=0;
        for($i=0;$i<count($data);$i++){
            if($array[$i]!=" "){
                $dat=Db::table('goods_sku')->where('id',$data[$i]['id'])->update(["thumb"=>$array[$i]]);
                if($dat>0){
                    $flag=1;
                }
            }
        }
        if($flag>0){
            return true;
        }else{
            return false;
        }
    }

    public function delet($id){
        $data=Db::table('goods_spu')->where('id',$id)->update(["imgs"=>""]);;
        if($data>0){
            return true;
        }else{
            return false;
        }
}
    public function dele($id,$idd){
        $data=Db::table('goods_sku')->where(['spu_id'=>$id,'id'=>$idd])->update(["thumb"=>""]);;
        if($data>0){
            return true;
        }else{
            return false;
        }
    }
    public function add($id,$count){
        return Db::table('goods_spu')->where('id',$id)->update(["content"=>$count]);;
    }
}