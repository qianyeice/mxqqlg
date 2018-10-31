<?php
/**
 * Created by PhpStorm.
 * User: Mr.Hu
* Date: 2018/6/20
* Time: 15:54
*/
namespace app\api\model;

use think\Db;
use think\Model;

class View_coupon extends model{


    // 过期优惠券
    public function availableCoupons($id){
        $data = $this
            ->where('member_id', $id)
            ->where('end_time', '<', time())
            ->field('get_time,end_time,name,couponicon,instructions,couponcash,coupontype,couponvalue')->select();
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


    // 可用优惠券
    public function avai($id){
        $data = $this
            ->where(array('member_id' => $id, 'isuse' =>'0'))
            ->where('end_time', '>', time())
            ->field('get_time,end_time,name,couponicon,instructions,couponcash,coupontype,couponvalue')->select();
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

    //  已用优惠券
    public function Coupons($id){
        $data = $this
            ->where(array('member_id' => $id, 'isuse' =>'1'))
//            ->where('end_time', '>', time())
            ->field('get_time,end_time,name,couponicon,instructions,couponcash,coupontype,couponvalue')->select();
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


}