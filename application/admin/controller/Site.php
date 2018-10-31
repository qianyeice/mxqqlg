<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/29
 * Time: 11:56
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Site_information;

class Site extends adminController
{
    /**
     * 站点信息
     * @return \think\response\View
     */
    public function index()
    {
        $inf = new Site_information();
        $data = $inf->infall();
        return view('index')->assign('inf', $data[0]);
    }
    /**
     * time:18-4-10 22.19
     * name:邓剑
     * 站点设置 - 站点信息 更新数据
     */
    public function siteupdata(){
        $array=input('array/a');
        $id=array_pop($array);
        $inf=new Site_information();
        return $inf->infupdata($id,$array);
    }
}