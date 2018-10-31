<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/17
 * Time: 11:35
 */

namespace app\api\controller;

use apiController\apiController;

/**
 *首页
 * 龙云飞
 * Class Shouye
 * @package app\api\controller
 */
class Shouye extends apiController
{
    /**
     * 龙云飞
     * 首页通知
     * @return string
     */
    public function syTongzhi(){
        $tongzhi=new \app\api\model\Shouye();
//        $data="9";
        $data=$tongzhi->gongGao();
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);

    }

    /**
     * 首页导航城市汇
     * 龙云飞
     * @return string
     */
        public function syNav(){
//        $data="15";
        $nav=new \app\api\model\Shouye();
        $data=$nav->cityNav();
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

    /**
     * 首页活动
     * 龙云飞
     * @return string
     */
    public function syActivity(){
//        $data="11";
        $syhuodong=new \app\api\model\Shouye();
        $data=$syhuodong->syHuodong();
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }
}
