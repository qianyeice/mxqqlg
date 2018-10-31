<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/27
 * Time: 14:06
 */

namespace app\api\controller;

use apiController\apiController;
use app\api\model\View_member_member_groupbuy;

class GroupPurchase extends apiController
{
    /**
     * 当前商品的其他团长
     * time ：18-3-27 14:56
     * author :冯云祥
     */
    public function MoreRegiments()
    {
        //商品id
        $goodsID = input("goodsID");
        $view_member = new View_member_member_groupbuy();
        $data = $view_member->commodityGroupInquiry($goodsID);
        $this->apiJournal($data["type"], $data["lang"], $data["data"]);
        return $this->apiReturn($data["type"], $data["lang"], $data["data"]);
    }

    public function team()
    {
        $team = input("team");
        $id = input("userid");
        $view_member = new View_member_member_groupbuy();
        $data = $view_member->team($team, $id);
        $this->apiJournal($data["type"], $data["lang"], $data["data"]);
        return $this->apiReturn($data["type"], $data["lang"], $data["data"]);
    }


}