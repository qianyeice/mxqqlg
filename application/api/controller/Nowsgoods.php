<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/20
 * Time: 15:14
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\GoodsSpu;
use app\api\model\Order;
use  think\model;

class Nowsgoods extends apiController
{
    /**
     * 40、新手专区页新手商品详情接口
     * 陈昌海
     * 18.3.20  18:20
     * $id为新手商品id
     */
    public function index()
    {
        $id = input('post.id');
        //   实例化GoodsSpu
        $mod = new GoodsSpu();
        //   调用nowsgoods传递商品ID,获取数据
        $shop=$mod->nowsgoods($id);
//        dump($shop);
        //return DataReturn($shop,'noGoods');//修改
        return $this->apiReturn($shop["type"],$shop["lang"],$shop["data"]);
    }

    /**
     * 41、判断是否是新手
     * 陈昌海
     * 18.3.22  15:20
     * $uid为用户id
     */
    public function  judge()
    {
        $uid = input('post.id');
        //   实例化GoodsSpu
        $news = new Order();
        //   调用NewPeople传递用户ID
        $people = $news->NewPeople($uid);
        return $this->apiReturn($people["type"],$people["lang"],$people["data"]);
       
    }
}