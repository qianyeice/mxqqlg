<?php
namespace app\api\controller;

use apiController\apiController;
use app\api\model\Member;

class Integral extends apiController
{
    /**总积分，VIP等级
     * 李磊2018-3-24 14:50
     * @return array 返回会员中心数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function Integral()
    {
        //        接入传入id
        $id = input("post.userID");
        //   实例化Member
        $data = new Member();
        //        引用dmember_assets方法
        $val = $data->member_assets($id);
        //        调用返回数据
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);
    }

}