<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/29
 * Time: 9:59
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewInvoice;

class Lnvoiceman extends adminController
{
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * 发货单管理页面
     * Date: 2018/3/29
     * Time: 9:59
     */
    public function index()
    {
        //        实例化ViewRefund
        $data = new ViewInvoice();
        $search=input('get.keyword')?input('get.keyword'):null;
        $start = (input('page')) ? input('page')+1: 1;
        $limit = (input('limit')) ? input('limit') : 10;
        //        判断get，val值是否存在，
        $type = input('get.type') ? input('get.type') : 0;
//        传递获取对应类型数据
            $val = $data->invoice_distribution($search,$type,$start,$limit);
            $count=$val['data']['count'];
            unset($val['data']['count']);

        //        向页面传递参数

        $this->assign('type', $type);
        $this->assign('val', $val);
        $this->assign('count', $count);
        $this->assign('limit', $limit);
        return view('index');
    }

    /**
     * 删除返货单
     * @return mixed
     */
    function ajax_del()
    {
        $data = new ViewInvoice();
//        向M传递ID
        $val = $data->Lnvoiceman_del(input('post.id'));
        return $val;
    }
}