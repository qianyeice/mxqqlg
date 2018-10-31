<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/29
 * Time: 10:46
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Wechat_payment;


class Payment extends adminController
{
    public function index()
    {
        $up = new Wechat_payment();
        return view('index')->assign('up', $up->upa());
    }

    /**
     * time:18-4-12 20.50
     * name:邓剑
     * 支付方式  卸载
     */
    public function uninstall()
    {
        $string = input('string');
        $unid = input('unid');
        $pay = new Wechat_payment();
        $op=$pay->upa();
        if ($string == $op['operation']) {
            $string = '0';
        }
        $pay = new Wechat_payment();
        return $pay->chatunall($unid, $string);
    }
}