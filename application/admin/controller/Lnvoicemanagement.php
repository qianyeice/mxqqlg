<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/29
 * Time: 9:59
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewSkuInvoice;
use think\Controller;

class Lnvoicemanagement extends adminController
{
//    打印
    public function index()
    {
        $data = new ViewSkuInvoice();
//        获取URL传值type处理，没处理，全部
        $id = input('get.id');
//        传递获取对应类型数据
        $val = $data->sku_invoice($id);
//        计算商品总加，数量
        $sum= $this->value($val['data']);
        $this->assign('sum',$sum);
        $this->assign('val',$val);
        return view('index');
    }

    function value($val)
    {
        $sum=array();
        $f=0;
        for($i=0;$i<count($val);$i++){
            $f+=$val[$i]['sku_amount'];
        }
        $sum['money']=$f;
        $sum['number']=count($val);
        return $sum;
    }
}