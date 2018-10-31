<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 11:43
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Delivery;
use app\admin\model\ViewInvoice;

class Confirmdelivergoods extends adminController
{
    /**
     *确认发货物流
     * @return \think\response\View
     */
    function index()
    {
        //获取URL传值
        $id = input('get.id');
//        实例化
        $data = new ViewInvoice();
//        调用方法
        $val = $data->qr_order($id);
        $this->assign('val', $val);
//        获取物流信息
        $dar = new Delivery();
        $log = $dar->logistics_confirm();
        $this->assign('log', $log);
        return view();
    }

    /**
     *订单发货，物流选择
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     */
    function ajax_logistics()
    {
        $id=input();
        $id=json_decode($id['id'],true);
        $wul = input('post.wul')?input('post.wul'):"";
        $d_sn=input('post.delivery_sn')?input('post.delivery_sn'):"";
        $o_sn = input('post.o_sn');
        $text = input('post.text');
        $o_id=input('post.o_id');
        $data = new ViewInvoice();
//        调用方法
        $val = $data->confirm_order_logistics($id, $wul, $d_sn,$o_sn,$text,$o_id);
        return $val;
    }

    /**
     * 修改订单物流信息
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function ajax_replace()
    {
        $id = input('post.id');
        $logid = input('post.log');
        $sn = input('post.sn');
        $text = input('post.text');
        $data = new ViewInvoice();
        $val = $data->replace_order_logistics($id, $logid, $sn, $text);
        return $val;
    }
}