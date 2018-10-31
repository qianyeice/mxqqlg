<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/20
 * Time: 17:52
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class Procominfor extends Model
{
    function adds($id,$name,$cate,$barnd,$special,$sales,$number,$status,$deli,$weight,$volume,$content)
    {
        if($id!=null){
            $data = ['id'=>$id,'name'=>$name,'catid'=>$cate,'brand_id'=>$barnd,'is_special'=>$special,'Sales_volume'=>$sales,'notice'=>$number,'status'=>$status,'delivery_template_id'=>$deli,'weight'=>$weight,'volume'=>$volume,'content'=>$content];
            $feeds = Db::table('goods_spu')->where("id",$id)->update($data);
            $feedsId=$id;
        }else{
            $data = ['name'=>$name,'catid'=>$cate,'brand_id'=>$barnd,'is_special'=>$special,'Sales_volume'=>$sales,'notice'=>$number,'status'=>$status,'delivery_template_id'=>$deli,'weight'=>$weight,'volume'=>$volume,'content'=>$content];
            $feeds = Db::table('goods_spu')->insert($data);
            $feedsId = Db::table('goods_spu')->getLastInsID();
        }
        return $feedsId;
    }
    /*
     * 查询addspu视图
     */
    function sel($id)
    {
        $ele['spu'] = Db::table('goods_spu')->where('id',$id)->find();
        $ele['sku'] = Db::table('goods_sku')->where('spu_id',$id)->select();
        return $ele;
    }
    /*
     * 查询品牌
     */
    function brand()
    {
        $bar = Db::table('barnd')->field('id,name')->select();
        return $bar;
    }
    /*
     * 查询运费模块
     */
    function delivey_template()
    {
        $deli = Db::table('freight_formwork')
            ->where('is_delete',0)
          ->field('id,name')->select();
        return $deli;
    }
}