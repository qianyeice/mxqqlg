<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 18:18
 */

namespace  app\api\model;
use think\Model;
use think\Db;

class Shopping_Cart extends Model{
    /*
     * 购物车删除物品
    * 冯云祥
    * member_id:用户id；shop_id：购物车id
    */
    function Shoppingcart($shop_id){
        $data=Db::table('shop')->where( 'id',$shop_id)->delete();
        if($data==0){
            $array["type"]=0;
            $array["lang"]='error';
            $array['data'] = '';
        }else{
            $array["type"]=1;
            $array["lang"]='success';
            $array['data'] = $data;
        }
        return $array;
    }
}