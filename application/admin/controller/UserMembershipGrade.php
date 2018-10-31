<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\18 0018
 * Time: 10:01
 */
namespace app\admin\controller;

use app\admin\model\Member_group;
use think\Controller;

class UserMembershipGrade extends Controller {
    /**
     * name: 编辑会员等级
     * 2018.4.18  10:52
     * user： 白锦国
     * @return \think\response\View
     */
    function index(){
        $id=$_GET['id'];
        $data=new Member_group();
        $data=$data->set($id);
        $this->assign('id',$id);
        if (empty($data[0]['sign_config'])){
            $array=[
                'day_sign'=>'',
                'finish_sign'=>'',
            ];
            $this->assign([
                'array'=>$array,
            ]);
        }else{
            $json=$data[0]['sign_config'];
            $array=json_decode($json,true);
                $this->assign([
                    'array'=>$array
                ]);
        }
        return view('User_membership_grade/index');
    }

    function init(){
        $id=input('id');
        $json=json_encode(input());
        $data=new Member_group();
        $data=$data->signin($id,$json);
//        $data=1;
        if ($data==1){
            echo '更新成功，即将跳转.....';
            header("refresh:1;url=?s=admin/user_level/index");//$url就是你的跳转路径
        }
    }

    function load(){
        $id=input('id');
        $data=new Member_group();
        $data=$data->set($id);
        $data=$data['0']['sign_config'];
        $data=json_decode($data,true);
        $data=$data['add'];
        return $data;
    }
}