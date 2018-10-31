<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\24 0024
 * Time: 14:41
 */
namespace app\api\model;
use think\Db;
use think\Model;

Class Comment_details extends Model {
    /*
     * @param $sku_id:商品id
     * Time: 2018\3\24  14:37 name:
     */
    function Method($spu_id){
        $data=Db::table('comment')->where("spu_id",3)->cache(7200)->select();
        var_dump($data);exit;
        if(count($data)>0){
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array['data']=$data;
        }else{
            $array["type"]=0;
            $array["lang"]=lang('error');
        }

        return $array;
    }
}