<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 14:08
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewInvoice;
use https\curl;

class Confirmcomplete extends adminController
{
    /**
     * 确认订单完成
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
     * 确认完成，订单
     * @return array
     */
    function ajax_complete()
    {
        $id=input("post.order_id");
        $mgs=input("post.msg");
        $data = new ViewInvoice();
        $val = $data->confirm_order_complete($id,$mgs);
        return $val;
    }
}