<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/30
 * Time: 14:43
 */
namespace app\index\controller;
use think\Controller;

class Index extends Controller{
    function index(){
        $this->redirect(url('/'.'?s='.'admin/Login'));
    }
}