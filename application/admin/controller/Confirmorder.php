<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 11:17
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewInvoice;

class Confirmorder extends adminController
{
    /**
     * 确认订单
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
     * 确认订单
     * @return array
     */
    function ajax_confirm_order()
    {
        $id = input('post.id');
        $msg= input('post.msg');
        $sn= input('post.order_sn');
        $data = new ViewInvoice();
        $val=$data->confirm_order($id,$msg,$sn);
        return $val;
    }
}