<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 17:01
 */

namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Notification_system;

class Notice extends adminController
{
    /**
     * 通知设置（通知系统）
     * @return View
     */
    public function index(){
        $data=new Notification_system();
        $ass=$data->notification_system();
        $this->assign('data',$ass);
        return view();
    }
    /**
     * 卸载支付方式
     * $id:当前选中数据id
     * Time: 2018\4\6  18:06
     * name：白锦国
     */
    function uninstall(){

        $id=input('id');

        $is_uninstall=input('is_uninstall');
        $datas=new Notification_system();
        $data=$datas->uninstall($id,$is_uninstall);
        return $data["lang"];
    }
}