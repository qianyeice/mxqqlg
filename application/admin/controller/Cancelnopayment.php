<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 10:59
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Barnd;
use app\admin\model\ViewInvoice;

class Cancelnopayment extends adminController
{
    /**
     * 取消没付款
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
     * 没付款取消订单
     * @return array
     */
    function ajax_nopay()
    {
        $id = input('post.id');
        $data = new ViewInvoice();
        $val = $data->cancel_onpay($id);
        return $val;
    }
}