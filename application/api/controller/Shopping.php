<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 18:09
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Shopping_Cart;

class Shopping  extends apiController{
    /*
     * 购物车删除物品
     * 冯云祥
     * member_id:用户id；shop_id：购物车id
     */
    function Cart(){
//        $member_id = input("member_id");
        $shop_id = input("shop_id");
        if(!is_null($shop_id)){
            $da = new Shopping_Cart();
            $data = $da->Shoppingcart($shop_id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}