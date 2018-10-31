<?php
/**
 *
 * Created by PhpStorm.
 * Date: 2018/3/21
 * Time: 16:23
 */
namespace app\api\controller;

use apiController\apiController;
use app\api\model\View_coupon;

use app\api\model\Coupon_base;

class Coupon extends apiController{
    /**
     *优惠券
     * 胡焱
     * $id ：用户id
     */

    // 过期优惠券
    function envelopes()
    {
        $id = input('post.id');
        if(!is_null($id)){
            $eff = new View_coupon();
            // 转换时间戳
            $cxjg = $eff->availableCoupons($id);
            $data = typePdZero($cxjg, array(
                'get_time',
                'end_time',
            ));
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
    // 可用优惠券
    function notused(){
        $id = input('post.id');
        if(!is_null($id)){
            $eff = new View_coupon();
            // 转换时间戳
            $cxjg = $eff->avai($id);
            $data = typePdZero($cxjg, array(
                'get_time',
                'end_time',
            ));
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
   //  已用优惠券
    function used(){
        $id = input('post.id');
        if(!is_null($id)){
            $eff = new View_coupon();
            // 转换时间戳
            $cxjg = $eff->Coupons($id);
            $data = typePdZero($cxjg, array(
                'get_time',
                'end_time',
            ));
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }


//    /**
//     *过期优惠券
//     * 冯云祥
//     * $id ：用户id
//     */
//    function envelopes(){
//        $ddd=new Coupon_base();
//        $id=input('id');
//        $data=$ddd->coupon_guoqi($id);
//        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
//        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
//    }

    // 优惠券未使用
//    function notused(){
//        $ddd=new Coupon_base();
//        $id=input('id');
//
//        $data=$ddd->couponnotused($id);
//        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
//        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
//    }
    //优惠券已使用
//    function used(){
//        $data=new Coupon_base();
//        $id=input('id');
//        $data=$data->couponused($id);
//        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
//        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
//    }
}