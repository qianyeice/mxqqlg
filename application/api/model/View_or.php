<?php

namespace app\api\model;

use think\Model;

class View_or extends Model
{
    /**
     * time:18-3-27 16.18
     * name:邓剑
     * @param $id   用户id
     * @param $name 商品规格
     * @return array    返回的数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //105 查看快递信息页面退货方式接口
    function wayRefund($id, $name)
    {
        $data = $this->where('r_mid', $id)->where('spec', $name)->find();
        $array = [];
        if (count($data) >= 1) {
            $array = [
                'type' => '1',
                'explain' => lang('yesway'),
                'data' => $num = [
                    'name' => $data['name'],
                    'logisticsn' => $data['logisticsn']
                ]
            ];
        } else {
            $array = [
                'type' => '0',
                'explain' => lang('noway'),
                'data' => count($data)
            ];
        }
        return $array;
    }
}