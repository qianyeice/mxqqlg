<?php
/**
 * Created by PhpStorm.
 * User: 酷炫的勇哥
 * Date: 2018/3/27
 * Time: 18:05
 */
namespace  app\api\model;
use think\Db;
use think\Model;

class Coupon_base extends Model{
    /**
     *过期优惠券
     * 冯云祥
     * $id ：用户id
     */
    public function coupon_guoqi($id){
        $time=time();
        $data=$this->query("SELECT * from coupon_base JOIN member_coupon on member_coupon.coupon_id=coupon_base.id where member_coupon.member_id=".$id);
        $ddd=array();
        if(count($data)>0){
            foreach ($data as $key=>$v){
                if(strtotime($v['endtime'])<$time){
                    $ddd[$key]=$v;
                }
            }
            $array["type"]=1;
            $array["lang"]=lang('success');
        }else{
            $array["type"]=0;
            $array["lang"]=lang('meishuju');
        }
        $array["data"]=$ddd;
        return $array;
    }

    /*
     * 未使用优惠券
     * $id ：用户id
     */
    public function couponnotused($id){
        $data=$this->query("SELECT * from coupon_base JOIN member_coupon on member_coupon.coupon_id=coupon_base.id where member_coupon.member_id=".$id." and member_coupon.isuse='0'");
        $ddd=array();
//        dump($data);
//        exit;
        if(count($data)>0){
//            foreach ($data as $key=>$v){
//                //isuse==0未使用优惠券
//                if($v['isuse']==0){
//                    $ddd[$key]=$v;
//                }
//            }

            $array["type"]=1;
            $array["lang"]=lang('success');
        }
        else{
            $array["type"]=0;
            $array["lang"]=lang('meishuju');
        }
        $array["data"]=$data;
        return $array;
    }


/*
 * 已使用优惠券
 * $id ：用户id
 */
    public function couponused($id){
        $data=$this->query("SELECT * from coupon_base JOIN member_coupon on member_coupon.coupon_id=coupon_base.id where member_coupon.member_id=".$id);
        $ddd=array();
        if(count($data)>0){
            foreach ($data as $key=>$v){
                //isuse==1已使用优惠券
                if($v['isuse']==1){
                    $ddd[$key]=$v;
                }
            }
            $array["type"]=1;
            $array["lang"]=lang('success');
        }
        else{
            $array["type"]=0;
            $array["lang"]=lang('meishuju');
        }
        $array["data"]=$ddd;
        return $array;
    }
}