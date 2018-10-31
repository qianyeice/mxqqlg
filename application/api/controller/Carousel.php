<?php
/**
 * Created by PhpStorm.
 * User: 威威一笑很倾城
 * Date: 2018/3/20
 * Time: 14:41
 */
namespace app\api\controller;
use app\api\model;
use apiController\apiController;

class Carousel extends apiController{

    /**
     * 首页商品轮播图
     * time:18-3-20 11:30
     * author:陈明福
     * @return mixed 返回轮播数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function carousel(){
        $adver=new model\Adver();
        $data=$adver->getHomeCarousel();
//        $this->apiJournal($data["type"],$data["lang"],$data["data"]);//有冲突
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
//        return $data;
    }
}