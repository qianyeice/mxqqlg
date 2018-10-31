<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/20
 * Time: 11:14
 */

namespace app\api\model;

use think\Db;
use think\Model;

class View_conupon_for_member_coupon extends Model
{
    /**
     * 查询用户可用优惠券数量
     * 丁龙
     * 18.3.22 15.14
     * @param $id传入用户id
     * @return int|string 返回该用户可用优惠券数量
     */
    public function effectiveCoupons($id)
    {
        $cxjg = $this->where(array(
            'member_id' => $id,
            'isuse' => '0'
        ))->where('end_time', '>', time())
            ->count('id');
        return $cxjg;
    }


    /**
     * 查询用户可用的优惠券
     * @param $id传入用户id
     * @return array
     */
    public function availableCoupons($id)
    {
        $data = $this->where(array(
            'member_id' => $id,
            'isuse' => '0'
        ))->where('end_time', '>', time())
            ->field('id,coupon_id,get_time,member_id,end_time,explain,img,min_price,money,name,start_time')->select();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $data->toArray();
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = '';
        }
        return $array;
    }

    public function reallyCou($id)
    {
        $data = Db::name("member_coupon")
            ->alias("mc")->join("coupon_base cb", "mc.coupon_id=cb.id")
            ->where("mc.member_id",$id)
            ->where("cb.is_display",1)
            ->where("mc.isuse",'0')
            ->where("mc.get_time","< time",date("Y-m-d"))
            ->where("mc.end_time","> time",date("Y-m-d"))
            ->field("mc.id,coupon_id,isuse,couponname,couponfor,couponicon,coupontype,minprice,maxprice,couponvalue,couponcash,couponred,instructions,endtime")
            ->select();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = $data;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'noData';
            $array["data"] = '';
        }
        return $array;


    }


    /**
     * 查询用户过期的的优惠券
     * @param $id传入用户id
     * @return array
     */
//    public function expiredCoupon($id)
//    {
//        $cxjg = $this->where(array(
//            'member_id' => $id,
//        ))->where('end_time', '>', time())
//            ->field('id,coupon_id,get_time,member_id,end_time,explain,img,min_price,money,name,start_time')->select();
//        $xgjg = DataReturn(DataContentJudgment($cxjg), 'Coupon');
//        $xgjg['data'] = bintToTime($xgjg['data'], array(
//            0 => 'get_time',
//            1 => 'member_id',
//            2 => 'end_time',
//            3 => 'start_time'
//        ));
//        return $xgjg;
//    }


}