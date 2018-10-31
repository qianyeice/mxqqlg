<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/24
 * Time: 14:42
 */

namespace app\api\model;

use think\Db;
use think\Model;

class Member_coupon extends Model
{
    /*新手优惠券

  陈健英
  */
    public function novice($dh)
    {
        $mem = Db::name('member')->where('mobile', $dh)->select();
        $end = Db::name('coupon_base')->where('couponfor', '3')->select();
        if ($end[0]['effectivetype'] == 1) {
            $get_time = $end[0]['starttime'];
            $end_time = $end[0]['endtime'];
        } elseif ($end[0]['effectivetype'] == 2) {
            $get_time = time();
            $end_time = strtotime('+' . $end[0]['effectivelen'] . ' day');
        }
        $no = array(
            'member_id' => $mem[0]['id'],
            'coupon_id' => 3,
            'isuse' => 1,
            'get_time' => $get_time,
            'end_time' => $end_time,
        );
        $cd=$this->save($no);
        return $cd;
    }
}