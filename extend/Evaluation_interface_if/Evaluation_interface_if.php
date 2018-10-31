<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\23 0023
 * Time: 20:51
 */
namespace Evaluation_interface_if;
use app\api\model\Evaluation_page;
use think\Db;

class Evaluation_interface_if{
    function judge($member_id,$content,$id){
//        $ids=array();
//        if(!isArray($id)){
//            $ids[]=$id;
//        }else{
//            $ids=$id;
//        }
//        var_dump($ids);
        if($member_id&&$id){
            if($content!=null){
                $spu_id = Db::table('goods_sku')->where('id','in',$id)->field('spu_id')->select();
                $datas=new Evaluation_page();
                $data=$datas->Method($member_id,$content,$spu_id);
                return $data;
            }else{
                $array=array();
                $array["type"]=0;
                $array["lang"]=lang('Hint_is_not_empty');
                $array["data"]=false;
                return $array;
            }
        }else {
            $array["type"]=0;
            $array["lang"]=lang('Hint_is_not_empty');
            return $array;
        }

    }
}