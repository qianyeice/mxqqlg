<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 13:11
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Site_courier;

class Expresssetup extends adminController
{
    /**
     * 快递设置
     * @return \think\response\View
     */
    public function index()
    {
        $cou = new Site_courier();
        return view('index')->assign('cou', $cou->couall());
    }

    /**
     * time:18-4-11 20.25
     * name:邓剑
     * 站点设置 快递设置 更新
     */
    public function siteupdata()
    {
        $array = input('array/a');
        $id = array_pop($array);
        $phone = "/^1[34578]\d{9}$/";
        if (preg_match($phone, $array[1])) {
            $cou = new Site_courier();
            return $cou->couupdata($id, $array);
        } else {
            return [
                'type' => '0',
                'explain' => '手机号码格式错误！'
            ];
        }
    }
}