<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 19:29
 */
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Admin_user;
use app\admin\model\Procominfor;
class Adminmember extends adminController
{
    public function index()
    {
        $admin=new Admin_user();

        $data=$admin->da();
        $this->assign('da',$data);
        return view();
    }
    public function add()
    {
        $id=input();
        $kot = new Procominfor();
        $admin=new Admin_user();
//        传输品牌的数据
        $apples = $kot->brand();
        $memu=$admin->memu();
        $user=$admin->admin_user($id);
        $this->assign('user', $user);
        $this->assign('memu', $memu);
        $this->assign('brand', $apples);
        return view();
    }
    public function add_add(){
        $input=input();
        $user=new Admin_user();
        $s=$user->member_add($input);
        header('Location:?s=admin/Adminmember/index');
    }
    //删除
    public function upda(){
        $id=input();
        $user=new Admin_user();
        $user->up($id);
        header('Location:?s=admin/Adminmember/index');
    }
}