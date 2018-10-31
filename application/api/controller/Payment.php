<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/7/6
 * Time: 10:31
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Wechat_payment;
use think\Db;
use weChatPay\Pay;
use app\api\model\Member;
use app\api\model\Member_bank;

class Payment extends apiController{
    /**
     * 微信配置获取
     * time:18-3-27 15:303
     * author:陈明福
     * @return array 数据状态包；
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function weChat_payment(){
        $weChat=new Wechat_payment();
        $data=$weChat->weChatConf();
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

    /**
     * 微信支付接口
     * time:18-3-29 10:45
     * author:陈明福
     * @return array 数据状态包
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function weChatPay(){
        //用户id
        $id=input("post.id");
        //商品描述
        $Commodity_Description=input("post.describe ");
        //订单号
        $orderNumber=input("post.orderNumber");

        $member=new Member();
        //用户 订单数据验证
        $data=$member->getUser_details ($id,$orderNumber);

        //用户订单数据验证状态判断
        if($data["type"]==1){
            //用户配置获取
            $array=$this->weChat_payment();
            //下单接口实例化
            $payObj = new Pay($array,config("weChatPayUrl"));
//            dump($payObj);exit;
            //下单数据定义
            $payInfo = array(
                'body'=>$Commodity_Description,
                'fee'=>$data["data"]["money"],
                'openId'=>$data["data"]["openid"],
                "orderSn"=>$orderNumber,
            );
            //下单调用
            $payRes = $payObj->toPay($payInfo);
            //数据返回
            return $this->apiReturn(1,"success",$payRes);
        }else{
            //失败返回
            return $this->apiReturn($data["type"],$data["lang"],$data["lang"]);
        }

    }

    /**
     * 付款
     * sn 生成的订单号
     * coupon 使用的优惠券id
     * dream 使用的梦想币数量
     * money 付款金额
     * uid 用户id
     */
    function pay(){
        $fp = fopen( "lock.txt", "r");
        if(flock($fp,LOCK_EX | LOCK_NB))
        {
            $sn=input("post.sn");//生成的订单号
//            $coupon=input("post.coupon");//使用的优惠券id
            $dream=input("post.dream");//使用的梦想币数量
            $money=input("post.money");//付款金额
            $uid =input("post.uid");//用户id
            $paymethod=intval(input("post.paymethod"));//支付方式 0余额 1微信
//            $payStatus = model("Order");
            $payStatus=new \app\api\model\Order();
            $res=$payStatus->paySuccess($sn,$dream,$money,$uid,$paymethod);
            if($res==1){
                return 1;
            }else{
                return 2;
            }
        }
        else
        {
            echo "系统繁忙，请稍后再试";
        }

        fclose($fp);
    }

    /**
     * @return array 返回信息
     */
    function redenvelopes(){

        if(session("Redenvelopes")){

            $data = [
                "type"=>1,
                "lang"=>"成功",
                "data"=>session("Redenvelopes")
            ];
        }else{
            $data = [
                "type"=>0,
                "lang"=>"失败",
                "data"=>[]
            ];
        }
        return $data;
    }

    public function wxhb(){
        $data=Db::name("red_envelopes")->order("id desc")->find();
        $date=array();
        array_push($date,$data);
        if($date){
            $data = [
                "type"=>1,
                "lang"=>"成功",
                "data"=>$date
            ];
        }else{
            $data = [
                "type"=>0,
                "lang"=>"失败",
                "data"=>""
            ];
        }
        return $data;

    }


    function Put_forward(){
        $id = input("member_id");//提现的用户ID
        $money = input("money");//金额
        $Presentation_mode = input("Presentation_mode");//提现方式
        $Account_number = input("Account_number");//提现到的账户
        if(!is_null($id)&&!is_null($money)&&!is_null($Presentation_mode)&&!is_null($Account_number)){
            $a=new Member_bank();
            $data=$a->tixian($id,$money,$Presentation_mode,$Account_number);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
    //微信充值
    function wxchongzhi(){
        $fp = fopen( "lock.txt", "r");
        if(flock($fp,LOCK_EX | LOCK_NB))
        {
            $money=input("post.money");//付款金额
            $uid =input("post.uid");//用户id
            $paymethod=intval(input("post.paymethod"));//支付方式 0微信 1银行卡
            $payStatus=new \app\api\model\Order();
            $res=$payStatus->wxchongzhi($money,$uid,$paymethod);
            return $res;
        }
        else
        {
            echo "系统繁忙，请稍后再试";
        }
        fclose($fp);
    }
}
