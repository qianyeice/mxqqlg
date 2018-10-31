<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 14:37
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewInvoice;

class Ordertovoid extends adminController
{
    /**
     * 订单作废页面
     * @return \think\response\View
     */
    function index()
    {
        $id = input('get.id');
//        实例化
        $data = new ViewInvoice();
        $val = $data->confirm_payment_page($id);
        $this->assign('val', $val);
        return view();
    }
    /**
     * 订单作废
     * @return array
     */
    function ajax_tovoid()
    {
        $id=input('post.id');
        $data = new ViewInvoice();
        $val = $data->order_to_void($id);
        return $val;
    }
}