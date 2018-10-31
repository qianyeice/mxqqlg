<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/24
 * Time: 16:32
 */

namespace app\api\model;

use think\Model;

class Shop extends Model
{
    /**
     * 添加购物车 Shop_append()
     * @param  $data 获取数据
     * @param $rlsts 接收数据
     * @param $check 查询数据
     * @param $cart 添加数据
     * @param $array 定义返回参数
     * @return return 返回数据
     * 岳军章
     * 2018-3-27 9：00
     */
    public function Shop_append($data)
    {
        //查询数据
        $check = $this
            ->where(['member_id' => $data['member_id'], 'spu_id' => $data['spu_id'], 'sku_id' => $data['sku_id'], 'fc_type' => $data['fc_type']])
            ->find();

        if ($check == null) {
            //没有数据则添加
            $cart = $this->save($data);
        } else {
            //有数据则增加数量
            $cart = $this
                ->where(['member_id' => $data['member_id'], 'sku_id' => $data['sku_id'], 'fc_type' => $data['fc_type']])
                ->setInc('number', $data['number']);
        }

        // 返回参数
        $array = array();
        if ($cart) {
            $array["type"] = 1;
            $array["lang"] = 'Add_success';
            $array["data"] = $cart;

        } else {
            $array["type"] = 0;
            $array["lang"] = 'Add_failure';
            $array["data"] = $cart;
        }

        return $array;

    }


}