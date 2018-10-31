<?php

namespace app\api\model;

use think\Model;

class View_goods extends Model
{
    /**
     * time:18-3-24 10.34
     * name:邓剑
     * @param $id 用户的id
     * @param $skuName 商品名称
     * @param $skuName  商品名称
     * @param $spec  商品规格
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //99
    function detailRefund($id, $orderId, $skuName, $spec)
    {
        $data = $this->where(array('mid' => $id, 'orderid' => $orderId, 'spec' => $spec, 'sku_name' => $skuName))->find();
        $array = [];
        if (count($data) > '0') {
            $array = [
                'type' => '1',
                'explain' => lang('yesdetail'),
                'data' => $num = [
                    'type' => $data['type'],
                    'sku_amount' => $data['sku_amount'],
                    'spec' => $data['spec'],
                    'sku_name' => $data['sku_name'],
                    'url' => $data['url'],
                    'img' => $data['img'],
                    'time' => $data['time'],
                    'reason' => $data['reason'],
                    'number' => $data['number']

                ]
            ];
        } else {
            $array = [
                'type' => '0',
                'explain' => lang('nodetail'),
                'data' => count($data)
            ];
        }

        return $array;
    }
    /**
     * time:18-3-27 11.3
     * name:邓剑
     * @param $id 用户的id
     * @return array    返回的数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    // 106 我的退款页面退款商品详情接口
    function goodsRefund($id)
    {
        $data = $this->where('mid', $id)->where('type', '<>', '')->select();
        $array = [];
        if (count($data) >= '1') {
            $array = [
                'type' => '1',
                'lang' => lang('yesgoodsRefund'),
                'data' => $data
            ];
        } else {
            $array = [
                'type' => '0',
                'lang' => lang('nogoodsRefund'),
                'data' => count($data)
            ];
        }
        return $array;
    }
}