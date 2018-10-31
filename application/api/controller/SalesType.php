<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/20
 * Time: 16:13
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\GoodsSpu;
class SalesType extends apiController {

    /**
     * time:3-20 16:57
     * author:陈明福
     * 商品销售类型查询
     * @return mixed 返回查询到的数据或者对应的语言包
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    //接口已确认，app+微信，7月17
    public function getSalesType(){
        //销售类型获取 !!!待修改！！！
            $GoodsSup=new GoodsSpu();
            $data=$GoodsSup->getGoodsType();
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式

    }
}