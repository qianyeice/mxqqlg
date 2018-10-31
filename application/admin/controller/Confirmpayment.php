<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 10:12
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewInvoice;

class Confirmpayment extends adminController
{
    /**
     * 确认付款
     */
    function index()
    {
        //获取URL传值
        $id = input('get.id');
//        实例化
        $data = new ViewInvoice();
//        调用方法
        $val = $data->confirm_payment_page($id);
        $this->assign('val', $val);
        return view();
    }

    /**
     * 确认付款
     * @return mixed
     */
    function ajax_payment()
    {
        $id=input('post.id');
        $sn=input('post.sn');
        $time=input('post.time');
        $money=input('post.money');
        $mode=input('post.mode');
        $third=input('post.third');
        $remarks=input('post.remarks');
        $data = new ViewInvoice();
        $val = $data->confirm_payment($id,$time,$money,$mode,$third,$remarks,$sn);
        return $val;
    }
}