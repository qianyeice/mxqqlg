<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/20
 * Time: 15:08
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\GoodsSku;
use app\api\model\Order;
use app\api\model\View_creatorder;

class Orderdetails extends apiController
{
    /**
     * 订单商品状态
     * User: 冯云祥
     * uid ： 用户id    judge ： 传入判断商品类型参数
     */
    public function allgoods()
    {
        $order = new Order();
        $id=input('uid');
        $type=input('judge');
        $startLimit=input('startLimit');
        $endLimit=input('endLimit');
        // $judge 传入的参数为0的话代表查询全部商品
        $data = $order->allgoods($id,$type,$startLimit,$endLimit);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

    /**
     * 商品信息查询
     * time:18-3-22 16.26;
     * author:陈明福
     * @return array 返回商品信息；
     * @throws \think\exception\DbException
     */
    public function commodityDetails()
    {
        //接收 商品id 组（商品副表id组）
        $dataPacket = input("post.data");
        $goodsSku = new GoodsSku();
        $data = $goodsSku->commodityDetailsInquiry($dataPacket);
        $array = array();
        //商品循环处理判断
        foreach ($dataPacket as $k => $v) {
            //判断商品id相应的商品数据是否存在
            if (isset($data[$k])) {
                $array[$k]["data"] = $data[$k]->toArray();
                $array[$k]["type"] = 1;
                $array[$k]["lang"] = lang("success");
            } else {
                $array[$k]["type"] = 0;
                $array[$k]["lang"] = lang("ErroneousGoods");
            }
        }
        return TimeConversion($array, ["up_time"]);
    }

    /**
     * 支付页面详情  payments()
     * @param $member 用户id
     * @param $model 实例化模型
     * @param $$rlts 接收数据
     * @return return 返回数据
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     * author:岳军章
     * time：18-3-27 15:40
     */

    public function payments()
    {
        //用户id
        $member['buyer_id'] = input('post.member_id');
        $member['id'] = input('post.id');

        //实例化模型
        $model = new Order();
        $rlts = $model->payment($member);

        return $this->apiReturn($rlts['type'], $rlts['lang'], $rlts['data']);
    }


    /**
     * 随机红包金额
     * time 18-3-27 11:37
     * author ：陈明福
     * @return array 返回状态数据包；
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function orderRedPackage()
    {
        //订单编号
        $orderNumber = input("post.orderNumber");
        //用户购买金额
        $money = number_format(input("post.money"), 2);
        //用户id
        $userID = input("post.id");
//        var_dump($userID,$money,$orderNumber);
        //用户随机红包金额
        $RandomAmount = number_format(rand(0.001, ($money * 0.005)), 2);
        $order = new Order();
        $data = $order->balancePaymentQuery($orderNumber, $money, $userID, $RandomAmount);
        return $this->apiReturn($data["type"], $data["lang"], $data["data"]);
    }


    /**
     * 点击提交订单生成订单接口
     * time 18-3-27 11:37
     * author ：谢岸霖
     * $datas接收页面的二维数组
     * $id页面用户的id
     * $order为一维数组装的订单信息
     * $ordersku为二维数组订单内物品信息
     */

    public function generateorder()
    {
        $data = new View_creatorder();
        $id=input('id');
        $order=input('order');
        $ordersku=input('ordersks');
        $data=$data->orderCreat($id,$order,$ordersku);
        return $data;
    }

    /**
     * 邓强
     * @return array
     */
    public function orderdetails()
    {
        $order = new Order();
        $uid=input('uid');
        $sn=input('sn');
        $data = $order->orderdetails($uid,$sn);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

    //删除订单  orderid订单id
    public function deleteOrder(){
        $order=new Order();
        $orderid=input("orderid");
        $data =$order->deleteOrder($orderid);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }
    //团购类型接口
    public function gouwu(){
        $order=new Order();
        $data =$order->tuangou();
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }
    public function order_ygm(){
        $goods = input();
        $dd=json_decode($goods['goods'],true);
        $order=new Order();
        $data =$order->order_ygm($dd);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }





}