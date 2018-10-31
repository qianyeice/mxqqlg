<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Admin_memu;
use think\Controller;
use think\facade\Session;
use think\Db;
class Page extends adminController
{
    public function index()
    {
        $a=new Admin_memu();
        $top=$a->admin_topMenu();
        if(input('id')!=null){
          $left=  $a->admin_leftMenu(input('id'));
        }else{
           $left= $a->admin_leftMenu();
        }
       $data= $this->menu;
        $array=array();
        if($data!=null){
            foreach($data as $vo){
                $array[]=$vo;
            }
            $data=array(
                'top'=>$array[0],
                'left'=>$array[1],
            );
        }else{
            $this->error('没有权限');
        }




        /**
         *登陆用户名查询错误
         * 岳军章
         * 2018/4/23 16：50
         */
       /* $name=Db::name('admin_user')->field('username')->select();
        $this->assign('data',$data);
        $this->assign('name',$name[0]['username']);*/

        /**
         *修改查询登陆用户名
         * 岳军章
         * 2018/4/23 16：50
        */
        $username = Session::get('id');
        $name=Db::name('admin_user')->where('id',$username)->field('username')->find();
        //dump($name);exit;
        $this->assign('name',$name);
        $this->assign('data',$data);
        return view('index');
    }
    /**
     * 吴正勇
     *  clean 清除session
     * 用户注销
     * Session::has('id') 内置方法 判断session 返回true  flase
     * Session::clear();内置方法 清除session  不是删除
     */
    public function clean()
    {
        $session=Session::has('id');
        if($session==true){
            $val['type']='1';
            $val['Prompt']='注销成功';
            Session::clear();
        }else{
            $val['type']='0';
            $val['Prompt']='未登录';
        }
        echo json_encode($val)  ;
    }
}