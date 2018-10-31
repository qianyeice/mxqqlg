<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 14:30
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Member_group;

/**
 * Class UserLevelEditing
 * @package app\admin\controller 渲染用户等级编辑页面
 * name：龚文凤
 *time:2018.3.29 14：35
 */
class UserLevelEditing extends adminController{
    function index(){
         if (isset($_GET['id'])){
             $data=new Member_group();
             $id=$_GET['id'];
             $data=$data->set($id);
//             dump($data[0]);
             $url=[
                 'url'=>'up',
                 'id'=>$_GET['id']
             ];
             $this->assign('data',$data[0]);
             $this->assign('url',$url);
         }else{
             $data=[
                'id'=>'',
                 'name'=>'',
                 'min_integral'=>'',
                 'max_integral'=>'',
                 'share_ratio'=>'',
                 'wear_ratio'=>'',
                 'description'=>''
             ];
             $url=[
                 'url'=>'init',
                 'id'=>''
             ];
             $this->assign('data',$data);
             $this->assign('url',$url);
         }
        return view();
    }

    function init(){
        $name=input('name');
        $min=input('min_integral');
        $max=input('max_integral');
        $bonus=input('share_ratio');
        $wastage=input('wear_ratio');
        $describe=input('description');
        $data=new Member_group();
        $add=$data->add($name,$min,$max,$bonus,$wastage,$describe);
//        $add=1;
        if ($add==1){
            echo '添加成功，即将跳转.....';
            header("refresh:1;url=?s=admin/user_level/index");//$url就是你的跳转路径
        }
    }

    function up(){
        $id=input('id');
        $name=input('name');
        $min=input('min_integral');
        $max=input('max_integral');
        $bonus=input('share_ratio');
        $wastage=input('wear_ratio');
        $describe=input('description');
        $data=new Member_group();
        $data=$data->updata($id,$name,$min,$max,$bonus,$wastage,$describe);
//        $data=1;
        if ($data==1){
            echo '修改成功，即将跳转.....';
            header("refresh:1;url=?s=admin/user_level/index");//$url就是你的跳转路径
        }else if($data==0){
            echo '未修改，即将跳转.....';
            header("refresh:1;url=?s=admin/user_level/index");//$url就是你的跳转路径
        }
    }
}