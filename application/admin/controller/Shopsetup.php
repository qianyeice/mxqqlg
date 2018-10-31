<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 13:17
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Site_shopping;

class Shopsetup extends adminController{
    /**
     * 购物设置
     * @return \think\response\View
     */
    public function index()
    {
        $sho=new Site_shopping();
        return view('index')->assign('sho',$sho->shoall());
    }
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 购物设置 更新
     */
    public function siteupdata(){
        $checked=input('checked/a');
        $array=input('array/a');
        $id=array_pop($array);
        $cyan=array_merge($checked,$array);
        $sho=new Site_shopping();
        return $sho->shoupdata($id,$cyan);
    }
}