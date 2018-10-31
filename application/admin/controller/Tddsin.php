<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Config;;
use app\admin\model;
/**
 * 易婷婷
 * 首页通知
 */
class Tddsin extends adminController{
//通知页面
    public function index(){
        return view();
    }

//接收输入通知数据
    public function tongzhi(){
//      var_dump($_POST);
//      die();
        $val= input('post.val');
        $config = new Config();
        $aa=$config->xiugai($val);
      if($aa==1){
          return true;    //开启状态
      }else{
          return false;   //关闭状态
      }

    }

//关闭通知栏状态
    public function kaiguan(){
//        var_dump($_POST);
//        die();
        $val= input('post.kg');
        $config = new Config();
        $config->kaiguan($val);
        return true;
    }

}