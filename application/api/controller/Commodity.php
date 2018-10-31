<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/17
 * Time: 11:12
 */

namespace app\api\controller;

use apiController\apiController;

/**
 * 商品相关的类
 * 龙云飞
 * Class Commodity
 * @package app\api\controller
 */
$comm=new \app\api\model\Commodity();

class Commodity extends apiController
{
    /**首页所有商品
     * @return string
     */
    public function syAllCommodity(){
//        $data="3";
        $comm=new \app\api\model\Commodity();
        $data=$comm->getCommData();
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

    /**
     * 商品详情
     * 龙云飞
     * @return string
     */

    public function commodityDetails(){
//        $data="13";
        $spuId=input("spu_id");
        $huodongId=input("huodong_id");
        $comm=new \app\api\model\Commodity();
        $data=$comm->getCommodityDetails($spuId,$huodongId);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);

    }
}