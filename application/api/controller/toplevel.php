<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/5/4
 * Time: 15:01
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\toplevelclassification;
class toplevel extends adminController{
    public function top(){
        $data=new toplevelclassification();
        return ($data);
    }
}