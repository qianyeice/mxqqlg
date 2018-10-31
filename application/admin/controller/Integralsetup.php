<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 13:15
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Site_integralset;

class Integralsetup extends adminController
{
    /**
     * 积分设置
     * @return \think\response\View
     */
    public function index()
    {
        $int = new Site_integralset();
        return view('index')->assign('int', $int->intall());
    }

    /**
     * time:19-4-11 15.25
     * name:邓剑
     * 站点设置 积分设置 - 更新
     */
    public function siteupdata()
    {
        $array = input('array/a');
        $id=array_pop($array);
        $int=new Site_integralset();
        return $int->intupdata($id,$array);
    }
}