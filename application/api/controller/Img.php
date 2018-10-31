<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/17
 * Time: 11:29
 */

namespace app\api\controller;

use apiController\apiController;

/**
 * 图片相关
 * 龙云飞
 * Class Img
 * @package app\api\controller
 */
class Img extends apiController
{
    /**首页轮播
     * 龙云飞
     * @return string
     */
    public function syLunbo()
    {
//        $data="7";
        $sylb=new \app\api\model\Img();
        $data=$sylb->syLunbo();
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }
}