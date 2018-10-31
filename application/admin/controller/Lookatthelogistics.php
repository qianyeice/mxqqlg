<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/12
 * Time: 15:12
 */

namespace app\admin\controller;

use adminController\adminController;

class Lookatthelogistics extends adminController
{
    /**
     * 查看物流信息
     * @return \think\response\View
     */
    function index()
    {
        return view();
    }
}