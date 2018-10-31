<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 13:09
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Site_logisticscost;

class Logisticscostsetup extends adminController{
    /**
     * 物流费用设置
     * @return \think\response\View
     */
    public function index()
    {
        $log=new Site_logisticscost();
        return view('index')->assign('log',$log->logall());
    }
    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 快递设置 更新
     */
    public function siteupdata(){
        $array=input('array/a');
        $id=array_pop($array);
        $log=new Site_logisticscost();
        return $log->logupdata($id,$array);
    }

}