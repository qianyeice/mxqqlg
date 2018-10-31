<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 13:16
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Site_dream;

class Dreammoneysetup extends adminController
{
    /**
     * 梦想币设置
     * @return \think\response\View
     */
    public function index()
    {
        $dre = new Site_dream();
        $data = $dre->dreall();
        return view('index')->assign('dream', $data[0]);
    }
    /**
     * time:19-4-11 15.25
     * name:邓剑
     * 站点设置 梦想币设置 - 更新
     */
    public function siteupdata()
    {
        $array = input('array/a');
        $id = array_pop($array);
        $dre = new Site_dream($id, $array);
        return $dre->dreupdata($id, $array);
    }

}