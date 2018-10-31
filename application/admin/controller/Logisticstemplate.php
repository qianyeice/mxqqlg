<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\11 0011
 * Time: 10:33
 */
namespace app\admin\controller;
Class Logisticstemplate{
    /**
     * User: 白锦国
     * name: 物流模板页面
     * Date: 2018/4/11
     * Time: 10:36
     */
    function index(){
        echo input('id');
        return view('Logisticstemplate/index');
    }
}