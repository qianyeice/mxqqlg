<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/28
 * Time: 15:40
 */

namespace app\admin\model;

use think\Model;

class View_order extends Model
{
    /**
     * 支付方式统计数据
     * name:张平
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function pay_data()
    {
        $data = $this->field('moneys,online,wechat')->select();
        $online = 0;//线上支付
        $underline = 0;//线下支付(货到付款)
        $wechat = 0;//微信支付
        $balance = 0;//余额支付
        foreach ($data as $vo) {
            if ($vo['online'] == 1) {
                $online += $vo['moneys'];
                if ($vo['wechat'] == 1) {
                    $wechat += $vo['moneys'];
                } else {
                    $balance += $vo['moneys'];
                }
            } else {
                $underline += $vo['moneys'];
            }
        }
        $data = array(
            'online' => $online,
            'balance' => $balance,
            'wechat' => $wechat,
            'underline' => $underline
        );
        return $data;
    }

    /**
     * 订单地区分部统计数据
     * name:张平
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function order_num()
    {
        $data = $this->field('count(addr) as num,addr')->select();
        return $data;
    }
}