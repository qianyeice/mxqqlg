<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 18:16
 */

namespace app\api\controller;
use \app\api\model\Lottery_prize;
use apiController\apiController;

class Lotteryprize extends apiController
{
    /**
     * 大转盘奖品详情（并添加到对应表中）
     * @param $id 奖品id，$member_id 用户id
     * @return return 返回成功或失败
     * author:陈昌海
     * time：18-3-29 9:20
     */
    public function prize()
    {
        $prize_id = input('post.prize_id');
        $user_id =input('post.user_id');

        $lottery = new Lottery_prize();
        $table = $lottery->Lottery($user_id,$prize_id);
        return $this->apiReturn($table["type"],$table["lang"],$table["data"]);
    }
}