<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 17:47
 */

namespace app\api\controller;
use apiController\apiController;
use \app\api\model\Withdraw;

class Withdrawals extends apiController
{
    /**
     * 佣金页面提现
     * @param $id 用户id
     * @return return 返回数据
     * author:陈昌海
     * time：18-3-29 9:10
     */
    public function drawals()
    {
        $id = input('id');
        $with = new Withdraw();
        $table = $with ->draw($id);
        return $this->apiReturn($table["type"],$table["lang"],$table["data"]);
    }
}