<?php
namespace app\api\controller;
use apiController\apiController;
use app\api\model\GoodsSpu;
class MoreGoods extends apiController
{
    /**
     * 获取其他商品信息
     *  丁龙18.3.20 :16:10
     * @return array 状态数据包
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $id=input('post.id')?input('post.id'):1;

        $GoodsSpu=new GoodsSpu();
        $QueryResult=$GoodsSpu->other($id);
        return $this->apiReturn($QueryResult["type"],$QueryResult["lang"],$QueryResult["data"]);
    }
}
