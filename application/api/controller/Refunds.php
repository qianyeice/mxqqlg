<?php

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Delivery_template;
use app\api\model\Refund;
use app\api\model\View_choose;
use app\api\model\View_goods;
use app\api\model\View_or;

Class Refunds extends apiController
{
    /**
     * 判断退款接口
     * time:18-3-21 16.51
     * name:邓剑
     * @param $id  用户的id
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    //98 判断有没有退款接口
    public function judge()
    {
        $id = input('id');
        $refund = new Refund();
        $data = $refund->judgeRefund($id);
        //调用日志，传入返回的数据
        $this->apiJournal($data['type'], $data['parameter'], $data['data'],'用户的id：'.$id);
        return $this->apiReturn($data['type'], $data['parameter'], $data['data']);
    }
    /**
     * time:18-3-24 12.13
     * name:邓剑
     * @param $id  用户的id
     * @param $skuName  商品名称
     * @param $skuName  商品名称
     * @param $spec  商品规格
     * @return array 返回的数据
     */
    //99 退款详情页面商品详情接口
    function detail()
    {
        $id = input('id');
        $orderId = input('orderId');
        $skuName = input('skuName');
        $spec = input('spec');

//        $id = 1;
//        $orderId = 1;
//        $skuName = "商品名称33";
//        $spec = "规格";


        $view_goods = new View_goods();
        $data = $view_goods->detailRefund($id, $orderId, $skuName, $spec);
        //调用日志，传入返回的数据
        $this->apiJournal($data['type'], $data['explain'], $data['data']);
        return $this->apiReturn($data['type'], $data['explain'], $data['data']);
    }
    /**
     * 提交退款接口
     * time:18-3-22 14.50
     * name:邓剑
     * @param $id  用户的id
     * @param $orderId  订单的id
     * @param $choose  退货方式 0:仅退款 1：退货退款
     * @param $skuName  商品名称
     * @param $spec  商品规格
     */
    //100 提交退款申请
    function audit()
    {
        $id = input('id');
        $orderId = input('orderId');
        $choose = input('choose');
        $skuName = input('skuName');
        $spec = input('spec');
        $refund = new Refund();
        $data = $refund->submitRefund($id, $orderId, $choose, $skuName, $spec);
        //调用日志，传入返回的数据
        $this->apiJournal($data, lang('nosubmit'), $data);
        return $this->apiReturn($data, lang('nosubmit'), $data);
    }
    /**
     * time:18-3-22 15.56
     * name:邓剑
     * @param $id  用户的id
     * @param $orderId  订单的id
     * @param $skuName  商品名称
     * @param $spec  商品规格
     */
    //101 退款详情页判断退款是否成功
    function whether()
    {
        $id = input('id');
        $orderId = input('orderId');
        $skuName = input('skuName');
        $spec = input('spec');
        $refund = new Refund();
        $data = $refund->whetherRefund($id, $orderId, $skuName, $spec);
        //调用日志，传入返回的数据
        $this->apiJournal($data, lang('nowhether'), $data);
        return $this->apiReturn($data, lang('nowhether'), $data);
    }
    /**
     * 取消退款接口
     * time:18-3-22 17.12
     * name:邓剑
     * @param $id  用户的id
     * @param $orderId  订单的id
     * @param $skuName  商品名称
     * @param $spec  商品规格
     */
    // 102 退款详情页取消退款
    function cancel()
    {
        $id = input('id');
        $orderId = input('orderId');
        $skuName = input('skuName');
        $spec = input('spec');
        $refund = new Refund();
        $data = $refund->cancelRefund($id, $orderId, $skuName, $spec);
        //调用日志，传入返回的数据
        $this->apiJournal($data, lang('nocancel'), $data);
        return $this->apiReturn($data, lang('nocancel'), $data);
    }
    /**
     * time:18-3-24 16.15
     * name:邓剑
     * @param $name 快递名称
     * @param $logisticsn   物流运单号
     * @param $username 收件人名称
     * @param $zipcode  邮编
     * @param $phone    联系电话
     * @param $address  邮寄地址
     * @param $reason   特别说明
     * @return array 返回的数据
     */
    //103 退款选择快递退回商品给卖家提交申请
    function courier()
    {
        $name = input('name');
        $logisticsn = input('logisticsn');
        $username = input('username');
        $zipcode = input('zipcode');
        $phone = input('phone');
        $address = input('address');
        $reason = input('reason');
        if ($name != null && $logisticsn != null && $username != null && $zipcode != null && $phone != null && $address != null && $reason != null) {
            $delivery_template = new Delivery_template();
            $data = $delivery_template->courierRefund($name, $logisticsn, $username, $zipcode, $phone, $address, $reason);
            //调用日志，传入返回的数据
            $this->apiJournal($data, lang('nocourier'), $data);
            return $this->apiReturn($data, lang('nocourier'), $data);
        } else {
            //调用日志，传入返回的数据
            $this->apiJournal('0', lang('nocourier'), '0');
            return $this->apiReturn('0', lang('nocourier'), '0');
        }
    }
    /**
     * time:18-3-24 17.44
     * name:邓剑
     * @param $id   用户id
     * @param $orderId  订单id
     * @return array 返回的数据
     */
    //104 退款详情页面判断卖家是否确定收货并退款
    function receive()
    {
        $id = input('id');
        $orderId = input('orderId');
        $refund = new Refund();
        $data = $refund->receiveRefund($id, $orderId);
        //调用日志，传入返回的数据
        $this->apiJournal($data, lang('noreceive'), $data);
        return $this->apiReturn($data, lang('noreceive'), $data);
    }
    /**
     * time:18-3-27 16.18
     * name:邓剑
     * @param $id   用户id
     * @param $name 商品规格
     * @return array 返回的数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //105 查看快递信息页面退货方式接口
    function way()
    {
        $id = input('id');
        $name = input('name');
        $view_or = new View_or();
        $data = $view_or->wayRefund($id, $name);
        //调用日志，传入返回的数据
        $this->apiJournal($data['type'], $data['explain'], $data['data']);
        return $this->apiReturn($data['type'], $data['explain'], $data['data']);
    }
    /**
     * time:18-3-27 11.3
     * name:邓剑
     * @param $id   用户id
     * @return array    返回的数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //106 我的退款页面退款商品详情接口
    function goods()
    {
        $id = input('id');
        if(!is_null($id)){
            $view_goods = new View_goods();
            $data = $view_goods->goodsRefund($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
    /**
     * time:28-3-27 17.52
     * name:邓剑
     * @param $id   用户id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    //107 我的退款页面判断退货还是退款还是退货并退款
    function choose()
    {
        $id = input('id');
        $view_choose = new View_choose();
        $data = $view_choose->chooseRefund($id);
        //调用日志，传入返回的数据
        $this->apiJournal($data['types'], $data['explain'], $data);
        return $this->apiReturn($data['types'], $data['explain'], $data);
    }

    //退款详情·中
    function Refund_application(){
        $id = input('sku_id');
        $uid=input("uid");
        $view_choose = new View_choose();
        $data = $view_choose->Refund_application($id,$uid);
//        调用日志，传入返回的数据
        $this->apiJournal($data['type'], $data['explain'], $data['data']);
        return $this->apiReturn($data['type'], $data['explain'], $data['data']);
    }

    public function panduantuikuan(){
        $order_id = input('order_id');
        $mid=input('id');
        $model = new View_choose();
        $rlst = $model->tkchankan($mid,$order_id);
        return $this->apiReturn($rlst["type"],$rlst["lang"],$rlst["data"]);
    }
}