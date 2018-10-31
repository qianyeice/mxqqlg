<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 12:49
 */
namespace app\admin\controller;
use adminController\adminController;

class Customadd extends adminController{
    /**
     * 自定义菜单添加
     * @return \think\response\View
     */
    public function index(){
        return view('index');
    }
}