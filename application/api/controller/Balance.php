<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/24
 * Time: 10:28
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Member;
use app\api\model\Order;

class Balance extends apiController{
    /**
     * 用户余额查询
     * time:18-3-24 10:47;
     * author:陈明福
     * @return array 状态数据包
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function balanceInquiry(){
        //用户ID 获取
        $userId=input("post.userID");
        $member=new Member();
        $data=$member->userBalanceInquiry($userId);
//        $this->apiJournal($data);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

    /**
     * 余额支付
     * time：18-3-24 20:16
     * author:陈明福
     * id: member_id(用户id)   orderNumber:订单Id
     * @return array 支付状态数据包；
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function balancePayment(){
        $userId=input("post.id");
        $orderNumber=input("post.orderNumber");
        $order=new Order();
        $data=$order->procedure_balance_payment($userId,$orderNumber);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
//      var_dump($data);
    }

}