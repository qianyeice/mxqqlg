<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 17:10
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\GroupCommodity;

class Group extends apiController{
    /**
     * 团购详情页面头像，商品详情 时间 差人，
     * 程建 2018-3-27 18:07
     * @return array
     */
    function group_commodity(){
        //        接入传入id
//        $userId = input("userID");
        $groupId = input("post.groupId");
        //   实例化GroupCommodity
        $data=new GroupCommodity();
        //        引用group_page方法
        $val = $data->group_page($groupId);
        //        调用返回数据
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);
    }

    /**用户参加团购，成为团长或团员
     * 陈健英 2018-3-28 16:37
     * @return array 返回数据
     */
    function group_add()
    {
        $gro_id = 0;
        $sn = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);  //订单号;
        $sku_id = input("post.sku_id");    //子商品id
        $is_leader = 1;   //团长
        $member_id = input("post.member_id");   //用户
        $nuw = input("post.nuw");         //  商品数量
        $delivery_amount = input("post.delivery_amount");         //  物流总额
        $real_amount = input("post.real_amount");         //  应付价格
        $paid_amount = input("post.paid_amount");         //  实付价格
        $address_name = input("post.address_name");         //  收货人
        $address_mobile = input("post.address_mobile");         //  电话号码
        $addre_detail = input("post.addre_detail");         //  详情地址
        $pro_id = input("post.pro_id");         //  团购规则
        $fc_type = input("post.fc_type");         //  特殊商品
        $fencheng = input("post.fencheng");         //  分成金额
        //   实例化GroupCommodity
        $data = new GroupCommodity();
        //        引用group_page方法
        if ($pro_id > 0) {               //是否为团购
            $group = $data->group_into($sku_id, $pro_id, $member_id, $is_leader, $sn);                                  //团购生成
            $gro_id = $group;
        }
        $val = $data->order($sn, $gro_id, $member_id, $sku_id, $nuw, $delivery_amount, $real_amount, $paid_amount, $address_name, $address_mobile, $addre_detail, $fc_type, $fencheng);    //订单生成

        //        调用返回数据
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);
    }


    public function getGroup()
    {
        $id = input("post.group_id");

        $view_member=new GroupCommodity();

        $res = $view_member->groupCou($id);

        return $this->apiReturn($res["type"],$res["lang"],$res["data"]);


    }

}