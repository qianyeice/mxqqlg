<?php
namespace app\admin\controller;

use adminController\adminController;
use think\Controller;

class Nextshelfproduct extends adminController{
    public function index(){
        return view('index');
    }
}