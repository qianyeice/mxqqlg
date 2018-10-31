<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\ViewRefundManagement;

class Detailsoforderreturn extends adminController
{
//    订单退货
    public function index()
    {
        //        实例化ViewRefundManagement
        $data=new ViewRefundManagement();
    //        获取URL传值type处理，没处理，全部
        $id=input('get.id');
   //        传递获取对应类型数据
        $val=$data->refund_goods($id);
        $this->assign('val',$val);
        return view();
    }

}