<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 12:54
 */
namespace app\admin\controller;
use adminController\adminController;

class  Automaticmessage extends adminController{
    /**
     * 消息自动回复
     * @return \think\response\View
     */
    public function index(){
        return view('index');
    }
}