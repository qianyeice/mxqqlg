<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/31
 * Time: 9:46
 */
namespace app\admin\controller;
use adminController\adminController;

class Statistics extends adminController{
    /**
     * 会员统计
     * @return \think\response\View
     */
    public function index(){
        return view('index');
    }
}