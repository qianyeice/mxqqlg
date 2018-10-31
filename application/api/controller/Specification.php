<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/5/24
 * Time: 15:09
 */

namespace app\api\controller;
use app\api\model\GoodsSku;
use apiController\apiController;

class Specification  extends apiController

{
    public function specificationCome()
    {

        /**
         * 邓锋
         * 商品规格
         */
        //$id 获取商品id
        $id = input('id');

        //实例化模型
        $model = new GoodsSku();
        //接收数据
        $sql = $model->specification($id);
        //返回数据

        return $this->apiReturn($sql["type"], $sql["lang"], $sql["data"]);
    }
}