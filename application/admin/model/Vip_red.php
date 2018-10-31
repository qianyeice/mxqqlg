<?php

namespace app\admin\model;

use think\Model;

class Vip_red extends Model
{
    /**
     *time:18-4-24 21.43
     * name:邓剑
     * 用户 - 全球分红 - 昨日分红池 - 分红剩余金额
     */
    public function vipyd()
    {
        $all = $this->select();
        $array = [];
        $cyan = [];
        $pink = [];
        foreach ($all as $k => $v) {
            $array[$k] = $v['yesterday_red'];
            $cyan[$k] = $v['proportion'];
        }
        $pink['redpoll'] = $this->my($array[0]);
        $list = $array[0] * ($cyan[0] / 10);
        $pink['redthe'] = $this->my($list);
        return $pink;
    }

    private function my($sum)
    {
        $num = strpos($sum, '.');
        if ($num) {
            $len = substr($sum, $num);
            if (strlen($len) == 2) {
                $sum = $sum . '0';
            } else {
                $sum = $sum;
            }
        } else {
            $sum = $sum . '.00';
        }
        return $sum;
    }
}