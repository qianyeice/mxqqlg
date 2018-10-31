<?php

namespace app\api\model;

use think\Model;

class Refund extends Model
{
    /**
     * time:18-3-21 16.16
     * name:邓剑
     * @return array    返回判断有没有退款数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //98
    function judgeRefund($id)
    {
        $data = $this->where('mid', $id)->where('type', '0')->select();
        $array = [];
        if (count($data) > 0) {
            $array = [
                'type' => '1',
                'parameter' => lang('yesRefund'),
            ];
        } else {
            $array = [
                'type' => '0',
                'parameter' => lang('noRefund'),
            ];
        }
        $array['data'] = count($data);
        return $array;
    }
    /**
     * time:18-3-22 14.47
     * name:邓剑
     * @param $id   用户的id
     * @param $orderId  订单的id
     * @param $choose  退货方式 0:仅退款 1：退货退款
     * @param $skuName  商品名称
     * @param $spec  商品规格
     * @return array    提交退款申请返回的数据
     */
    //100 提交退款
    function submitRefund($id, $orderId, $choose, $skuName, $spec)
    {
        $data = $this->save([
            'mid' => $id,
            'orderid' => $orderId,
            'goods_name' => $skuName,
            'spec' => $spec,
            'choose' => $choose,
        ]);
        return $data;
    }
    /**
     * @param $id   用户的id
     * @param $orderId  订单的id
     * @param $skuName  商品名称
     * @param $spec  商品规格
     * @return array    判断退款是否成功返回的数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //101 判断退款是否成功
    function whetherRefund($id, $orderId, $skuName, $spec)
    {
        $data = $this->where(array('mid' => $id, 'orderid' => $orderId, 'spec' => $spec, 'goods_name' => $skuName))->find();
        return $data['type'];
    }
    /**
     * time:18-3-22 17.11
     * name:邓剑
     * @param $id   用户的id
     * @param $orderId  订单的id
     * @param $skuName  商品名称
     * @param $spec  商品规格
     * @return array    取消退款申请返回的数据
     */
    //102 退款取消
    function cancelRefund($id, $orderId, $skuName, $spec)
    {
        $data = $this->where(array('mid' => $id, 'orderid' => $orderId, 'spec' => $spec, 'goods_name' => $skuName))->update(['type' => '']);
        return $data;
    }
    /**
     * time:18-3-24 17.44
     * name:邓剑
     * @param $id   用户id
     * @param $orderId  订单id
     * @return mixed 返回的数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //104 是否确定收货并退款
    function receiveRefund($id, $orderId)
    {
        $data = $this->where('mid', $id)->where('orderid', $orderId)->find();
        return $data['type'];
    }



}