<?php
namespace app\admin\controller;
use app\admin\model\Admin_login;
class Login
{
    public function index()
    {
        return view('index');
    }
    function  data(){
        $user=input('adminname');
        $pwd=input('password');

        $data=new Admin_login();
        $imp=$data->admin_login($user,$pwd);
        if($imp!=false){
            $val['type']='1';
            $val['Prompt']='成功';
        }else{
            $val['type']='0';
            $val['Prompt']='账号密码不正确请重新登录';
        }
        echo json_encode($val)  ;
    }

    function test (){
        session('openid', '123456'); //设置session
        echo '设置session-->' . session('openid') . '</br>';
    }

    function test1 (){
        echo '设置session  test2-->' . session('ss') . '</br>';
    }
}