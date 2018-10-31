<?php
namespace app\api\controller;
use apiController\apiController;
use app\api\model\View_conupon_for_member_coupon;
use dataJudgementExistence\existence;
class MyCoupon extends apiController
{
    /**
     * 提交订单页面判断是否有优惠券
     *  丁龙18.3.22 :9:10
     * 传入用户ID
     */
    public function index()
    {
        $id=input('post.id');
        $eff=new View_conupon_for_member_coupon();
        $cxjg=$eff->effectiveCoupons($id);
        $judgement =new existence();
        return $judgement->HomeCarouselHandle($cxjg,'Coupon');
    }

    /**
     * .优惠券页面可使用优惠券
     * 传入用户id
     * @return array 返回优惠券
     */
    public function  expiredCoupon(){
        $id=input('post.id');
        $eff=new View_conupon_for_member_coupon();
        // 转换时间戳
        $cxjg=$eff->availableCoupons($id);
        $jg=typePdZero($cxjg,array(
            0 => 'get_time',
            1 => 'member_id',
            2 => 'end_time',
            3 => 'start_time'
        ));
        return $this->apiReturn($jg['type'],$jg['lang'],$jg['data']);
    }

    public function goFor()
    {
        $id=input('id');
        if(!is_null($id)){
            $eff=new View_conupon_for_member_coupon();
            $data=$eff->reallyCou($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }


}
