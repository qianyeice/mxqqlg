<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 11:27
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\ShopGoods;

class Shopcart extends apiController{
    /**
     * 购物车页面商品
     * 程建 2018-3-27 11:46
     * @return array
     */
    public function shop_car_commodity(){
        //        接入传入id
        $userId = input("userID");
        if(!is_null($userId)){
            $data = new ShopGoods();
            //        引用shop_cart方法
            $data = $data->shop_cart($userId);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /**
     * 购物车页面限时商品
     *
     * @return array
     */
    public function shop_car_commoditys(){
        //        接入传入id
        $userId = input("userID");
        if(!is_null($userId)){
            $data = new ShopGoods();
            //        引用shop_cart方法
            $data = $data->shop_carts($userId);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /**
     * 购物车数据
     * 龙云飞
     * @return string
     */
    public function shopCarData(){
        $memberId=input("member_id");
//        $data="17";
        $shopcar=new ShopGoods();
        $data=$shopcar->shopCar($memberId);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);

    }
}