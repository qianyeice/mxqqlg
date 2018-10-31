<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Grant_authorization;
class Authorization extends adminController{
    /**
     * 授权
     * time：18-3-29 10:16
     * author:李磊
     * @return \think\response\View
     */
    public function index (){
        $data=new Grant_authorization;

        return view('Authorization/index');

    }
}