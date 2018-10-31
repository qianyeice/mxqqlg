<?php

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Member_group;
use app\admin\model\Order;
use app\admin\model\View_divlog;
use app\admin\model\Vip_red;

class GlobalBonusPool extends adminController
{
    /**
     * 全球分红主页
     * time 18-3-29 14:15
     * author:陈明福
     * @return \think\response\View
     */
    public function index()
    {
        $todaytime = strtotime('today');
        $today = date("Y-m-d H:i:s", $todaytime);
        //用户 - 全球分红 - 订单总金额
        $order = new Order();
        $all = $order->querys($today);
        //用户 - 全球分红 - 昨日分红池 - 分红剩余金额
        $vip = new Vip_red();
        //用户 - 全球分红 - 等级
        $mem = new Member_group();
//        $all=200.00;
//        dump($mem->level($all)[0]);
        $type = '1';
        return view()->assign([
            'all' => $all,
            'red' => $vip->vipyd(),
            'etc' => $mem->level($all, $type)[0],
        ]);
    }

    /**
     * time:18-4-25 16.20
     * name:邓剑
     * 用户分红数据
     */
    public function lists()
    {
        $end = input('end_time');
        $begin = input('begin_time');
        $name = input('keywords');
        $mgid = input('mgid');
        $start = !is_null(input('page')) ? input('page') + 1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') : 2;
        $div = new View_divlog();
        $con=$div->queryall($mgid,$start,$limit,$name,$begin, $end);
        $this->assign('limit',$limit );
        $this->assign('mgid',$mgid );
        $this->assign('count',count($con['count']) );
        return view()->assign('data',$con['data'] );
    }

    /**
     * time:18-4-25 16.20
     * name:邓剑
     * 用户分红数据 日期 用户名称搜索
     */
    public function init()
    {
        $end = input('end_time');
        $begin = input('begin_time');
        $name = input('hui');
        $mgid = input('mgid');
        $data = new View_divlog();
        return $data->sel($name, $begin, $end, $mgid);
    }

    public function dateoff()
    {
        //日期选择
        $date = input('date');
        $time = strtotime($date);
        $off=$time+86400;
        $dateof = date("Y-m-d H:i:s", $time);
        $dateoff = date("Y-m-d H:i:s", $off);
        $order = new Order();
        $redall = $order->datechoose($dateof,$dateoff);
        $mem = new Member_group();
        $type = '0';
        $data = $mem->level($redall, $type);
        return $array = [
            'allmo' => $redall,
            'amount' => $data,
        ];
    }
}