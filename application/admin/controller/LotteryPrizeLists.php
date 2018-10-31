<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/4/12
 * Time: 9:44
 */

namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Lottery_prize;
use think\facade\Request;


/**
 * 奖品配置列表
 * name:岳军章
 * time:2018 04 12 9:25
 * Class LotteryPrizeList
 * @package app\admin\controller
 */
class LotteryPrizeLists extends adminController
{
    /**
     * 奖品配置列表
     * @param
     * @return
     * name: 岳军章
     * time:2018 04 12 9:25
     */
    public function lists()
    {
        $model = new Lottery_prize();

        if(!empty(input('get.lottery_id'))){
            $_SESSION['lottery']=input('get.lottery_id');
        }
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') : 10;
        //查询总数量
       $number = $model->number($_SESSION['lottery']);
        $this->assign('count',$number);
        $this->assign('title',input("id"));

        //列表查询
        $lists = $model->lists($_SESSION['lottery'],$start,$limit);

        $this->assign('lists',$lists);
        $this->assign('limit', $limit);

        $this->assign('lottery_id',$_SESSION['lottery']);

        return view();
    }


    /**
     * 奖品配置列表删除
     * @param
     * @return
     * name: 岳军章
     * time:2018 04 14 14:25
     */

    public function delete()
    {
        $id =explode(",",input('id'));
        $model = new Lottery_prize();
        $date=$model->dele($id);
        return $date;
    }

}