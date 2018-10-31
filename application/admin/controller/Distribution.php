<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/11
 * Time: 14:44
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewInvoice;
use app\admin\model\ViewRefundManagement;

class Distribution extends adminController
{
    /*
     * 修改配送状态页面
     */
    function index()
    {
        $id = input('get.id');

        $this->assign('val', $id);
        return view();
    }

    /**
     * 配送状态修改
     * @return array
     */
    function ajax_distribution()
    {
        //        获取ajax传值
        $id=input('post.id');
        $type=input('post.type');
        $text=input('post.text');

        $data=new ViewInvoice();
        //        传递M层数据
        $val=$data->distribution_handle($id,$type,$text);
        return $val;
    }
}