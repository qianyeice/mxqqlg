<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 14:54
 */

namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\ViewInvoice;
use app\admin\model\ViewSkuInvoice;
use app\admin\model\Admin_user;
/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * 订单详情
 * Date: 2018/3/29
 * Time: 9:59
 */
class Orderinformation extends adminController
{
    function index()
    {
        $admin_user=$_SESSION['module']['id'];
        $user=new Admin_user();
        $auser=$user->user($admin_user);
        //        实例化ViewInvoice
        $data = new ViewInvoice();
//        获取URL传值type处理，没处理，全部
        $id = input('get.id');
//        传递获取对应类型数据
        $val = $data->order_details($id,$auser);
        $log = $data->or_log($id);
        $this->assign('log',$log);
        $this->assign('is_qx',$auser['is_supplier']);
        $this->assign('val',$val);
        return view("init");
    }
}