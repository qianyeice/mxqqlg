<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\29 0029
 * Time: 13:53
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\ViewRefundManagement;
use think\Controller;

class Refundprocessing extends adminController
{
    //订单退款详情
    public function index()
    {
        //        实例化ViewRefund
        $data=new ViewRefundManagement();
//        获取URL传值type处理，没处理，全部
        $id=input('get.id');
//        传递获取对应类型数据
        $val=$data->refund_goods($id);
//        向页面传递参数
        $this->assign('val',$val);
        return view();
    }

}
