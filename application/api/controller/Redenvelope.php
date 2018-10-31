<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/17
 * Time: 11:22
 */

namespace app\api\controller;

use apiController\apiController;

/**红包相关的类
 * 龙云飞
 * Class Redenvelope
 * @package app\api\controller
 */
class Redenvelope extends apiController
{

    /**首页现金红包
     * 龙云飞
     * @return string
     */
    public function syCashRe()
    {
        $memberId = input("member_id");
        $redenvelop=new \app\api\model\Redenvelope();
        $data = $redenvelop->syCash($memberId);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }
}