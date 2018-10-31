<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\22 0022
 * Time: 17:01
 */
namespace app\api\controller;
use app\api\model\Commodity_details;

class Evaluatecommodity{
    /**
     * @param $member_id:用户id
     * @param $spu_id:商品表id
     * @param $order:订单表id
     * 评价商品页面的商品详情
     * Time: 2018\3\22  17:06 name：白锦国
     */
    function Goods()
    {
        $member_id = input('post.member_id');
        $order = input('post.order');

        if ($member_id && $order) {
            $datas = new Commodity_details();
            return $datas->Goods($member_id, $order);
        } else {
            $array["type"] = 0;
            $array["lang"] = lang('network_error');
            return $array;
        }

    }
}