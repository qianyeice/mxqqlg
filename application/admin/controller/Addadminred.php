<?php
namespace app\admin\controller;
use
    adminController\adminController;
use app\admin\model\Admin_red;
use qiniuSdk\qiniuSdk;

class Addadminred extends adminController{
    /**
     * 礼包红包添加/编辑/删除
     * time：18-4-12 10:05
     * author:冯云祥
     */
    //编辑添加页面
    public function index()
    {
        $id=input('id');
        $data=new Admin_red();
        $zhi=$data->is_edit($id);
        $this->assign('zhi',$zhi);
        $this->assign('id',$id);
        return view();
    }

    //点击添加，编辑保存后跳转
    public function from_preservation(){


        //图片名为空处理办法
        if (input('is_edit')==0){
        if ($_FILES['site_logo']['name']==null){
            $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=Addadminred&a=index&type=1'));
        }else{
            $name=md5($_FILES['site_logo']['name'].time());
            }
        }else{
            $data=input();
            $new=new Admin_red();
            $new->edit($_GET['is_edit'],$data["name"],$data["value"],$data['site_logos'],$data["number"]);
            $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=Adminred&a=index'));

        }



        //图片临时路径
        $file_tmp=$_FILES['site_logo']['tmp_name'];
        $qiniu=new qiniuSdk();
//        $name=md5($_FILES['site_logo']['name'].time());
        $data=$qiniu->q_upload($name,$file_tmp);
        $logo='http://p5od7vvyw.bkt.clouddn.com/'.$data['key'];
        $data=input();

        //添加
//        $data['is_edit']
        if(($data["name"] && $data["value"] && $data["number"] && $_FILES['site_logo']['name'])!=null){
            $new=new Admin_red();
            if($data["is_edit"]==0){
                $new->add($data["name"],$data["value"],$logo,$data["number"]);
                $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=Adminred&a=index'));
            }else if ($data["is_edit"]!=0){
                //编辑

                $new->edit($_GET['is_edit'],$data["name"],$data["value"],$logo,$data["number"]);
                $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=Adminred&a=index'));
            };
        }else{
            //操作失败跳转页面
            $this->redirect(url('/'.'?s='.'admin/Succeed/index&c=Addadminred&a=index&type=1'));
        }
    }

    //单个删除
    public function from_delete(){
        $id=input('id');
        $new=new Admin_red();
        $new->shanchu($id);
        $this->redirect(url('/'.'?s='.'admin/Adminred/index'));
    }

    //全选删除
    public function ajax_delete(){
        $id=$_POST['array'];
        $new=new Admin_red();
        $qu=$new->shanchu($id);
        echo $qu;
    }
}