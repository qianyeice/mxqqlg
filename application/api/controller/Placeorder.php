<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2018/5/31
 * Time: 16:19
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Order;

/**
 * 立即购买生成待付款订单接口
 * 数组形式传入数据 键名orderInfo
 * 内含键：
 * buyer_id 用户id
 * real_amount 实付金额
 * address_name 姓名
 * address_mobile 电话
 * addre_detail 地址
 * promot_amount 优惠总金额
 * sku_amount 商品总金额
 * spec 商品规格
 * sku_name 商品名字
 * url 商品链接
 * img 商品图片
 * number 商品数量
 * goodid 商品id
 * "promotion_id 团购规则id
 * is_leader 是否为团长
 * shop 购物车id
 * author:张鑫
 * Date: 2018-06-01 05:55:17
 */
class Placeorder extends apiController
{
    public function order()
    {

        $orderInfo = input("orderInfo");
//        var_dump($orderInfo);exit;
//      $orderInfo = json_decode($orderInfo);
        $json=json_decode($orderInfo);
        if(!is_null($json)){
            foreach ($json as $v){
                if(is_null($v)||$v==""){
                    return $this->apiReturn(0,lang('faileds'));
                    break;
                }
            }
            $so = new Order();
            $data = $so->generatingOrder($orderInfo);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}