<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/10
 * Time: 17:46
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ViewRefund;

class Retreating extends adminController
{
    /**
     * 处理退款
     * @return \think\response\View
     */
    function index()
    {
        $id = input('get.id');
        
        $this->assign('val', $id);
        return view();
    }
    /**
     * 退款退货处理
     * 程建 20184-11 12：06
     * @return array
     */
    function ajax_handle()
    {
//        获取ajax传值
        $id=input('post.id');
        $type=input('post.type');
        $text=input('post.text');
        $data=new ViewRefund();
//        传递M层数据
       $val=$data->refund_handle($id,$type,$text);
       return $val;
    }
}