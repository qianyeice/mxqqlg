<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 12:42
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Order;
use app\admin\model\View_order;

class Sale extends adminController
{
    /**
     * name:张平
     * @return \think\response\View
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $obj = new Order();
        $data = $obj->cancel_order();//当日统计数据显示
        $this->assign('data', $data);
        return view('index');
    }

    /**
     * 统计页面统计图异步数据
     * name：张平
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\BindParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function post_data()
    {
        $obj = new Order();
        if (is_null(input('chart'))) {//两日期之间数据
            $data = $obj->date_statistics(input('day1'), input('day2'));
        } else {
            $pay = new View_order();
            if(input('chart')==2){//支付方式数据
                $data = $pay->pay_data();
            }elseif(input('chart')==3){
                $data=$pay->order_num();//订单地区分布数据
            }
        }
        return $data;
    }
}