<?php
namespace app\admin\controller;
use adminController\adminController;

class Succeed extends adminController{
    public function index(){
        $array=[];
        $array['c']=$_GET['c'];
        $array['a']=$_GET['a'];
        if(isset($_GET['type'])){
            $array['type']=$_GET['type'];
        }else{
            $array['type']='0';
        }
        return view('index')->assign('array',$array);
    }
}