<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 10:14
 */

namespace app\api\controller;
use app\api\model\Member;
use app\api\model\Turntable;
use apiController\apiController;

class Ttable extends apiController
{
    /**
     * 大转盘奖品详情
     * $lottery_id：活动id；$id：奖品id
     * User: 陈昌海
     * Date: 2018/3/24
     * Time: 11:50
     * Data：frequery：每日上限
     */
    public function index()
    {
        $lottery_id=input('post.lottery_id');
        $id=input('post.id');

        $turn = new Turntable();
        $table=$turn->prize($lottery_id,$id);
        return $this->apiReturn($table["type"],$table["lang"],$table["data"]);

    }

    /**
     * 大转盘抽奖次数
     * $id：用户id
     * User: 陈昌海
     * Date: 2018/3/27
     * Time: 17:03
     * Data：Sign：每日抽奖次数
     */
    public function draw()
    {
        $id = input('post.id');
        $luck = new Member();
        $luckdraw = $luck->draw($id);
//        dump($luckdraw);exit;
        return $this->apiReturn($luckdraw["type"],$luckdraw["lang"],$luckdraw["data"]) ;
    }

}