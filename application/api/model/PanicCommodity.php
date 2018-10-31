<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/22
 * Time: 10:11
 */

namespace app\api\model;

use think\Model;

class PanicCommodity extends Model
{
    /**
     * 判断商品是否为促销商品
     * 程建 2018-3-22 10:47
     * @param $id商品id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function Panic_promotion($id)
    {
        $data = $this->where('id', $id)->select();
        dump($data);
        //         判断是否有促销商品
        if (count($data) > 0) {
//             有促销商品返回
            return ['type' => 1, 'data' => '', 'lang' => 'Panic_Yes'];
        } else {
//             没有促销商品返回
            return ['type' => 0, 'data' => '', 'lang' => 'Panic_No'];
        }
    }
}