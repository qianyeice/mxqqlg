<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 13:14
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Site_bonus;

class Bonussetup extends adminController{
    /**
     * 分红设置
     * @return \think\response\View
     */
    public function index()
    {
        $bon=new Site_bonus();
        return view('index')->assign('bon',$bon->bonall());
    }
    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 分红设置 更新
     */
    public function siteupdata(){
        $array=input('array/a');
        $id=array_pop($array);
        $bon=new Site_bonus();
        return $bon->bonupdata($id,$array);
    }
}