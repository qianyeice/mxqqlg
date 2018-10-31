<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 13:43
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Sed_toset;

class Seoset extends adminController
{
    /**
     * SEO设置
     * @return \think\response\View
     */
    public function index()
    {
        $sed = new Sed_toset();
        return view('index')->assign('sed', $sed->sedall());
    }
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * SED设置  更新
     */
    public function sedupdata()
    {
        $array = input('array/a');
        $id = array_pop($array);
        $sed = new Sed_toset();
        return $sed->sedupdata($id, $array);
    }
}