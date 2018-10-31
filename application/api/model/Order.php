<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/20
 * Time: 17:13
 */

namespace app\api\model;

use think\Db;
use think\Exception;
use think\Model;
use weChatPay\Pay;

class   Order extends Model
{
    private $Redenvelopes;

    /**
     * 订单商品状态
     * User: 冯云祥
     * uid ： 用户id    judge ： 传入判断商品类型参数
     */
    function allgoods($uid, $judge, $startLimit, $endLimit)
    {
        $data = $this->alias('a')
            ->join('order_sku w', 'w.order_id=a.id')
            ->join('promotion_groupbuy p', 'p.id=a.groupbuy_id', 'LEFT')
            ->where(array('buyer_id' => $uid, "hd_type" => 3))
//                ->field('a.sn,a.id')
            ->limit($startLimit, $endLimit)
            ->select();
//        $data = $this->query('call proc_getOrderDetailsType('.$uid.','.$judge.')');
//        // 转换商品购买方式数据
//        $deta = new forloop\forloop();
//        if (isset($data[0])){
//            $data = $deta->forloop($data[0]);
//        }
//        if ($uid != null && $judge != null) {


//        if ($judge == 0) {
//            $data = $this->alias('a')
//                ->join('order_sku w', 'w.order_id=a.id')
//                ->join('promotion_groupbuy p', 'p.id=a.groupbuy_id', 'LEFT')
//                ->where(array('buyer_id' => $uid, "hd_type" => 3))
//                ->limit($startLimit, $endLimit)
//                ->select();
//            if (empty($data)) {
//                $array["type"] = 0;
//                $array["lang"] = lang("error");
//                $array["data"] = '';
//            } else {
//                $array["type"] = 1;
//                $array["lang"] = lang("success");
//                $array["data"] = $data;
//            }
//
//        } else {
//            $data = $this->alias('a')->join('order_sku w', 'w.order_id=a.id')->where(array('buyer_id' => $uid, "hd_type" => 3, 'status' => $judge))->select();
//            if (count($data) > 0) {
//                $array["type"] = 1;
//                $array["lang"] = lang("success");
//                $array["data"] = $data;
//            } else {
//                $array["type"] = 0;
//                $array["lang"] = lang("error");
//                $array["data"] = "";
//            }
//        }

//        } else {
//            $array["type"] = 0;
//            $array["lang"] = lang("canshu");
//            $array["data"] = '';
//        }

//        $data[0] = array(
//            'sn' => '123',
//            'buyer_id' => 3207,
//            'sku_id' => 1);
//        $data[1] = array(
//            'sn' => '123',
//            'buyer_id' => 3207,
//            'sku_id' => 2);
//        $data[6] = array(
//            'sn' => '123',
//            'buyer_id' => 3207,
//            'sku_id' => 100);
//        $data[2] = array(
//            'sn' => '123',
//            'buyer_id' => 3207,
//            'sku_id' => 3);
//        $data[3] = array(
//            'sn' => '223',
//            'buyer_id' => 3207,
//            'sku_id' => 1);
//        $data[4] = array(
//            'sn' => '333',
//            'buyer_id' => 3207,
//            'sku_id' => 1);
//        $data[5] = array(
//            'sn' => '223',
//            'buyer_id' => 3207,
//            'sku_id' => 1);
//        $data[7] = array(
//            'sn' => '333',
//            'buyer_id' => 3207,
//            'sku_id' => 890 );


        $arry = array();
        $arry2 = array();
        $arry3 = array();
        for ($i = 0; $i < count($data); $i++) {
            array_push($arry, $data[$i]["sn"]);
        }
        $arry = array_flip($arry);
        $arry = array_flip($arry);
        $arry = array_values($arry);
        for ($i = 0; $i < count($arry); $i++) {
            for ($j = 0; $j < count($data); $j++) {
                if ($arry[$i] == $data[$j]["sn"]) {
                    $arry2[$arry[$i]][$j] = $data[$j];
                };
            }
        }
        foreach ($arry2 as $v) {
            $arry2 = array_values($v);
            array_push($arry3, $arry2);
        }
//        echo count($arry);
//        array_unique($arry);
        if (count($arry3) > 0) {
            $array["type"] = 1;
            $array["lang"] = lang("success");
            $array["data"] = $arry3;
        } else {
            $array["type"] = 0;
            $array["lang"] = lang("error");
            $array["data"] = "";
        }
        return $array;
    }

    /**
     * 判断是否是新人(判断买家id是否等于用户id)
     * 陈昌海
     * @param $uid 传入用户id
     * @return $news 查询得到的数据
     * 18.03.20 17:20
     */

    function NewPeople($uid)
    {
        $news = $this->where('buyer_id', $uid)->find();

        $array = array();
        if (count($news) > 0) {
            //  说明有数据，有订单，即为老用户
            $array["type"] = 1;
            $array["lang"] = "olduser";
        } else {
            //  说明无数据，无订单，即为新用户
            $array["type"] = 0;
            $array["lang"] = "newuser";
        }
        $array["data"] = count($news);
        return $array;

    }

    /**
     * 余额支付
     * time：18-3-24 20:16
     * author:陈明福
     * @param $id 用户id
     * @param $order_number 订单编号
     * @return array 状态数据包
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public
    function procedure_balance_payment($id, $order_number)
    {
        $data = $this->query("call procedure_balance_payment(" . $id . ",'" . $order_number . "')");
        $array = array();
        switch ($data[0][0]["type"]) {
            case 1:
                $array["type"] = 1;
                $array["lang"] = "success";
                break;
            case 2:
                $array["type"] = 0;
                $array["lang"] = "Error_of_order_information";
                break;
            case 3:
                $array["type"] = 0;
                $array["lang"] = "Error_of_balance";
                break;
            case 4:
                $array["type"] = 0;
                $array["lang"] = "network_error";
                break;
            case 0:
                $array["type"] = 0;
                $array["lang"] = "UserInformationError";
                break;
        }
        return $array;
    }

    /**
     * 支付页面  payment()
     * @param $member 用户id
     * @return $array 返回参数
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     * author:岳军章
     * time：18-3-27 15:40
     */

    public
    function payment($member)
    {
        //查询数据
        $sql = $this
            ->where(['buyer_id' => $member['buyer_id'], 'id' => $member['id']])
            ->field('sn,real_amount,pay_type,pay_method,pay_sn')
            ->find();
        //定义返回参数
        $array = array();
        if (count($sql) > 0) {
            $array["type"] = 1;
            $array["lang"] = "success";
            $array["data"] = $sql;
        } else {
            $array["type"] = 0;
            $array["lang"] = "Choice_goods";
            $array["data"] = $sql;
        }
        return $array;

    }

    /**
     * @param $orderNumber 订单编号
     * @param $money 用户消费总金额
     * @param $randMoney 用户随机红包金额
     * @param $id 用户id
     * @return array 返回状态数据包
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public
    function balancePaymentQuery($orderNumber, $money, $randMoney, $id)
    {
//        var_dump($orderNumber, $money, $randMoney, $id);
        $data = $this->query("call procedure_balance_payment_query('" . $orderNumber . "'," . $money . "," . $randMoney . "," . $id . ") ");
        $array = array();
        switch ($data[0][0]["type"]) {
            case 1:
                $array["type"] = 1;
                $array["lang"] = "success";
                break;
            case 2:
                $array["type"] = 0;
                $array["lang"] = "network_error";
                break;
            case -1:
                //注意  此处原因是因为 用户订单实付金额金额 与传入金额数据不一致 引起 ！！！
                $array["type"] = 0;
                $array["lang"] = "Illegal_visit";
                break;
            case 0:
                $array["type"] = 0;
                $array["lang"] = "Error_of_order_information";
                break;
        }
        return $array;
    }

    /**
     * 未结算商品价格
     * 张关燚 2018 3 27 17：12
     * id:会员id*/
    public
    function unsettled($id)
    {
        $data = $this->field('pay_status=>0,paid_amount')->where('id', $id)->select();
        return $data;
    }


    function generatingOrder($orderInfo)
    {
//        var_dump($orderInfo["usecoin"]);exit;
        $orderNum = Pay::generateOrderNum();
        $groupId = 0;
        $orderInfo = json_decode($orderInfo, true);
        $orderInfo = $orderInfo[0];
        //团购生成团购相关信息、
        if ($orderInfo["promotion_id"] != '' && $orderInfo["promotion_id"] > 0) {
            $groupData = ["sku_id" => $orderInfo["goodsInfo"][0]["goodsId"], "promotion_id" => $orderInfo["promotion_id"], "end_time" => date("Y-m-d H:i:s", time() + 86400)];
            if ($orderInfo["is_leader"] == 1) {
                $groupId = Db::table("group_buy")->insertGetId($groupData);   //团长添加主表
            } else {
                $groupId = $orderInfo['group_id'];
            }
            $member_group = [
                "groupbuy_id" => $groupId,// 团购主表id
                "member_id" => $orderInfo["buyer_id"],//用户id
                "is_leader" => $orderInfo["is_leader"],//是否是团长
                "sku_id" => $orderInfo["goodsInfo"][0]["goodsId"],//商品ID
                "join_time" => date("Y-m-d H:i:s", time()),
                "promotion_groupbuy_id" => $orderInfo["promotion_id"],//团购规则
                "sn" => $orderNum//订单号
            ];
            Db::table("member_groupbuy")->insert($member_group);
        };

        //组合多商品的id
        $sql = "";
        for ($i = 0; $i < count($orderInfo["goodsInfo"]); $i++) {
            $sql .= $orderInfo["goodsInfo"][$i]["goodsId"] . ",";
        }
        $sql = substr($sql, 0, -1);

        /*查询对应商品的信息*/
        $result = Db::table("goods_sku")->where("id", "in", $sql)->field("sku_name,spec,thumb,fencheng")->select();
        $fencheng = 0;
        for ($i = 0; $i < count($result); $i++) {
            $fencheng += $result[$i]["fencheng"];
        }

        $data = [
            "sn" => $orderNum,
            "buyer_id" => $orderInfo["buyer_id"],
            "pay_type" => 1,
            "delivery_amount" => 0,
            "real_amount" => $orderInfo["real_amount"],
            "paid_amount" => ($orderInfo["real_amount"] - $orderInfo["promot_amount"]),
            "fencheng" => $fencheng,
            "address_name" => $orderInfo["address_name"],
            "address_mobile" => $orderInfo["address_mobile"],
            "addre_detail" => $orderInfo["addre_detail"],
            "invoice_tax" => 0,
            "status" => 4,
            "pay_status" => 0,
            "confirm_status" => 0,
            "finish_status" => 0,
            "use_coin" => $orderInfo["usecoin"],
            "promot_amount" => $orderInfo["promot_amount"],
            "groupbuy_id" => $groupId,
            "order_time" => date("Y-m-d H:i:s", time()),
            "cityid" => 29,
            "coupon" => $orderInfo["coupon"],
        ];

        $res = [$this->insertGetId($data), $orderNum];//增加并返回新增订单id


        /*循环向订单商品表添加数据*/
        for ($j = 0; $j < count($result); $j++) {
            //此处循环查询
            $skuData = [
                "order_id" => $res[0],
                "sku_amount" => $orderInfo["goodsInfo"][$j]["t_jiage"],
                "spec" => $result[$j]["spec"],
                "sku_name" => $result[$j]["sku_name"],
                "url" => "",
                "img" => $result[$j]["thumb"],
                "number" => intval($orderInfo["goodsInfo"][$j]["num"]),
                "goodid" => $orderInfo["goodsInfo"][$j]["goodsId"],
                "is_queren" => 0,
                "fc_type" => $orderInfo["goodsInfo"][$j]["fc_type"],
            ];
            /*减少商品数量*/
            Db::table("goods_sku")->where("id", $orderInfo["goodsInfo"][$j]["goodsId"])
                ->where("number", ">", intval($orderInfo["goodsInfo"][$j]["num"]))
                ->setDec("number", intval($orderInfo["goodsInfo"][$j]["num"]));
            Db::table("order_sku")->insert($skuData);
        }


        /*删除购物车商品*/
        if (isset($orderInfo["shop"])) {
            $shop = explode(",", $orderInfo["shop"]);
            for ($i = 0; $i < count($shop); $i++) {
                $w = ["id" => $shop[$i]];
                $delete = Db::table("shop")->where($w)->delete();
            }
        }

        Db::table("member_coupon coupon")
            ->where("coupon.member_id =" . $orderInfo["buyer_id"] . " and coupon.id =" . $orderInfo["coupon"])
            ->update(["isuse" => 1]);//将优惠券改为已使用

        $array = array();
        if ($res) {
            $array["type"] = 1;
            $array["lang"] = 'Add_success';
            $array["data"] = $res;

        } else {
            $array["type"] = 0;
            $array["lang"] = 'Add_failure';
            $array["data"] = "";
        }

        return $array;

    }


    /**
     * @param $sn
     * 付款成功
     *
     */
    function paySuccess($sn, $dream, $money, $uid, $paymethod)
    {
        Db::startTrans();
        try {
            $time = time();
            $orderData = ["pay_status" => 1, "pay_method" => $paymethod, "status" => 1, "pay_time" => date("Y-m-d H:i:s", time())];
            Db::table("order")->where("sn", $sn)->update($orderData);
            if ($paymethod == 0) {
                Db::table("member")->where("id", $uid)->where("money", ">=", $money)->setDec("money", $money);//减少用户金额

            }

//            dump(Db::table("member")->fetchSql()->where("id",$uid)->where("coin",">=",$dream)->setDec("coin",$dream));//减少梦想币

            $sql = "UPDATE member  SET coin=coin-?  WHERE  id = ?  AND coin >= ?";

            Db::execute($sql, [$dream, $uid, $dream]);//减少梦想币

//            Db::table("coupon_base coupon_base,member_coupon coupon")
//                ->where("coupon.member_id =".$uid." and coupon.coupon_id =".$coupon." and coupon_base.id = coupon.coupon_id")
//                ->update(["isdelete"=>0]);//将优惠券假删除

            //订单分成
            $parent1 = Db::name("member")->field("parent_id")->where("id", $uid)->select();
            $parent1 = $parent1[0]['parent_id'];//上级
            if ($parent1 > 0) {
                $oder = DB::table('order')->field("fencheng")->where("sn", $sn)->select();
                if (count($oder) > 0) {
                    $fencheng = $oder[0]['fencheng'];
                    $parent1_direct_sale = Db::name("distribution")->field("direct_sale")->where(["is_delete" => '1', 'name' => '员工'])->select();//员工分销比例
                    $distribution = $fencheng * ($parent1_direct_sale[0]['direct_sale'] / 100);//上级获得的钱
                    $zhi = [
                        'type' => '0',
                        'time' => time(),
                        'money' => $distribution,
                        'p_id' => $uid,
                        'member_id' => $parent1,
                        'order_sn' => $sn
                    ];
                    $cg = Db::name("get_distribution")->insert($zhi);//添加佣金日志
                    $parent2 = Db::name("member")->field("parent_id")->where("id", $parent1)->select();
                    $parent2 = $parent2[0]['parent_id'];//上上级id
                    if ($parent2 > 0) {
                        $parent1_indirect_sale = Db::name("distribution")->field("indirect_sale")->where(["is_delete" => '1', 'name' => '合伙人'])->select();//合伙人分销比例
                        $distribution2 = $fencheng * ($parent1_indirect_sale[0]['indirect_sale'] / 100);//上上级获得的钱
                        $zhi = [
                            'type' => '0',
                            'time' => time(),
                            'money' => $distribution2,
                            'p_id' => $uid,
                            'member_id' => $parent2,
                            'order_sn' => $sn
                        ];
                        $cg = Db::name("get_distribution")->insert($zhi);//添加佣金日志
                    }
                }

            }

//            $parent_id = Db::table("member")->where("id", $uid)->field("parent_id")->select();//查询父级id
//
//            if ($parent_id[0]["parent_id"] != null) {
//                $parent_id = $parent_id[0]["parent_id"];
//
//                $role = Db::table("distribution")
//                    ->join("member member", "member.is_special = distribution.id")
//                    ->where("member.id", $parent_id)->field("distribution.direct_sale")->select();//查询父级的角色对应的拥金比例
//
//                if (isset($role[0]["direct_sale"])) {
//                    $role = $role[0]["direct_sale"];
//                    $role = intval($role);
//                    $distribution = $role * $money * 0.01;//计算获得的拥金
//
//                    Db::table("member")->where("id", $parent_id)->setInc("distribution", $distribution);//增加推荐人的拥金
//
//                    $data = ["type" => 0, "time" => $time, "money" => $money, "p_id" => $uid, "member_id" => $parent_id];
//                    $logData = ["member_id" => $parent_id, "time" => $time, "money" => $money, "channel" => "商品购买佣金"];
//
//                    Db::table("get_distribution")->insert($data);//表get_distribution增加佣金记录
//
//                    Db::table("distrbution_log-4")->insert($logData);//表distrbution_log增加佣金记录
//                }
//            }

            $max = $money * 0.01;//最大金额为商品金额的1%
            $this->Redenvelopes = $this->randFloat(0, $max);//随机生成红包金额

            $red = ["name" => "商品购买红包", "value" => $this->Redenvelopes, "data" => $time];
            $member_log_time = date("Y-m-d H:i:s", $time);
            $member_log = ["member_id" => $uid, "value" => $this->Redenvelopes, "action_type" => "随机红包", "time" => $member_log_time,];
            Db::table("red_envelopes")->insert($red);//增加红包

            Db::table("member")->where("id", $uid)->setInc("money", $this->Redenvelopes);//将红包增加到金额

            Db::table("member_log")->insert($member_log);
            session("Redenvelopes", $this->Redenvelopes);
            Db::commit();
            return $type = 1;
        } catch (Exception $e) {
            Db::rollback();
            return $type = 0;
        }

    }

    /**
     * @return mixed 返回红包
     */
    function redenvelopes()
    {
        return $this->Redenvelopes;
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     * 生成红包金额
     */
    function randFloat($min = 0, $max = 1)
    {
        return round($min + mt_rand() / mt_getrandmax() * ($max - $min), 2);
    }

    //订单详情
    public
    function orderdetails($uid, $sn)
    {
        if ($uid != null && $sn != null) {
            $date = [
                "buyer_id" => $uid,
                "sn" => $sn
            ];
            $data = $this->alias('a')->join('order_sku w', 'w.order_id=a.id')->where($date)->select();
            $array = array();
            $array["type"] = 1;
            $array["lang"] = lang("success");
            $array["data"] = $data;
        } else {
            $array["type"] = 0;
            $array["lang"] = lang("success");
        }
        return $array;


    }

    public
    function deleteOrder($orderid)
    {
        $orderCon = Db::name("order_sku")->where("id", $orderid)->field("order_id")->select();
        $res = Db::name("order_sku")->where("id", $orderid)->delete();
        $res2 = Db::name("order")->where("id", $orderCon[0]["order_id"])->delete();
        $array = array();
        if ($res && $res2) {
            $array["type"] = 1;
            $array["lang"] = 'Add_success';
            $array["data"] = 1;

        } else {
            $array["type"] = 0;
            $array["lang"] = 'Add_failure';
            $array["data"] = "";
        }

        return $array;
    }

    public
    function tuangou()
    {
        $data = Db::name('promotion_groupbuy')->field('id,title,explain')->select();
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'Add_success';
            $array["data"] = $data;

        } else {
            $array["type"] = 0;
            $array["lang"] = 'Add_failure';
            $array["data"] = "";
        }

        return $array;
    }

//大宝宝 改于7月12，判定活动商品购买数量
    public
    function order_ygm($goods)
    {
        $data = $goods;
        $sql1 = '';
        $sql2 = '';
        foreach ($data as $k => $v) {
            if ($k == 0) {
                $sql1 .= '( Promotion_commodity_id=' . $v['fc_type'] . ' and spu_id = ' . $v['goodsId'] . ' )';
                $sql2 .= '(goodid = ' . $v['goodsId'] . ' and fc_type  = ' . $v['fc_type'] . ')';
            } else {
                $sql1 .= ' or ( Promotion_commodity_id=' . $v['fc_type'] . ' and spu_id = ' . $v['goodsId'] . ' )';
                $sql2 .= ' or (goodid = ' . $v['goodsId'] . ' and fc_type  = ' . $v['fc_type'] . ')';
            }
        }

        $xianbuy = Db::table('promotion_commodity_relation')->field('spu_id,Promotion_commodity_id,promotion_commodity.number as numder')
            ->join('promotion_commodity', 'promotion_commodity.id=promotion_commodity_relation.promotion_commodity_id')
            ->where($sql1)
            ->select();

        $yigoubuy = Db::table('huodong_ygm')
            ->field('sum(number)as sum,goodid,fc_type')
            ->group('goodid,fc_type')
            ->where('(' . $sql2 . ')  and status  in ("0","1","2","3") and buyer_id = 5')
            ->select();


//        dump($xianbuy);
//        dump($yigoubuy);

        $xiangoushu = array();
        $yigoushu = array();
        $goumaishu = array();

        foreach ($data as $v) {
            if ($v['fc_type'] != '1') {
                $goumaishu[$v['fc_type'] . '-' . $v['goodsId']] = $v['num'];
            }
        }

        foreach ($xianbuy as $v) {
            $xiangoushu[$v['Promotion_commodity_id'] . '-' . $v['spu_id']] = $v['numder'];
        }

        foreach ($yigoubuy as $v) {
            $yigoushu[$v['fc_type'] . '-' . $v['goodid']] = $v['sum'];
        }

//
//        dump($goumaishu);
//        dump($xiangoushu);
//        dump($yigoushu);
        $biaoji = true;
        foreach ($goumaishu as $k => $v) {
            if (isset($yigoushu[$k])) {
                $goumaishu[$k] += $yigoushu[$k];
            }
            if (isset($xiangoushu[$k])) {
                if ($xiangoushu[$k] >= $goumaishu[$k]) {
                    $goumaishu[$k] = true;
                } else {
//                    $goumaishu[$k] = false;
                    $biaoji = false;
                    break;
                }
            } else {
//                var_dump($k);
//                $goumaishu[$k] = false;
                $biaoji = false;
                break;
            }
        }
        $array = array();
        if ($biaoji == true) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = '1';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'error';
            $array["data"] = '0';
        }
        return $array;
    }

    /**
     * 立刻购买的订单提交
     * 龙云飞
     */
    public function buyNow()
    {
        $data = ["成功"];
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"] = '1';
        } else {
            $array["type"] = 0;
            $array["lang"] = 'error';
            $array["data"] = '0';
        }

        return $array;
    }

    //微信充值
    function wxchongzhi($money, $uid, $paymethod)
    {
        $orderData = [
            "start" => 0,//未完善，默认为 微信
            "money" => $money,
            "wtype" => $paymethod,
            "time" => date("Y-m-d H:i:s", time()),
            "member_id" => $uid
        ];
        $c = Db::table("member")->where('id',$uid)->value('money');//查询原有金额
        $b = Db::table("member")->where('id',$uid)->setField('money',($money+$c));//原有金额+充值金额并且更新
        $a = Db::table("Krypton_gold_log")->insert($orderData);
        if(count($a)>0 && count($b) > 0){
            return 1;
        }else{
            return 0;
        }
    }
}
