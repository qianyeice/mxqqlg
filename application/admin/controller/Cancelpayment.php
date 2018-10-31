<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 11:20
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Barnd;
use app\admin\model\ViewInvoice;

class Cancelpayment extends adminController
{
    /**
     * 取消订单，已付款页面
     * @return \think\response\View
     */
    function index()
    {
        $id = input('get.id');
//        实例化
        $data = new ViewInvoice();
        $val = $data->cancel_payment($id);
        $this->assign('val', $val);
        return view();
    }

    /**
     *取消订单，添加退款
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function ajax_cancel_payment()
    {
        $data = new ViewInvoice();
        $val = $data->confirm_cancel( input('post.'));
        return $val;
    }
}