<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 15:46
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewInvoice;

class Modifymoney extends adminController
{
    /**
     * 修改应付总额
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

    function ajax_modif()
    {
        $id= input('post.id');
        $money= input('post.val');
        $array=['real_amount'=>$money];
        $data = new ViewInvoice();
        $val= $data->up_money($id,$array);
        return $val;
    }
}