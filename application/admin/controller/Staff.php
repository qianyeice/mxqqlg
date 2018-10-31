<?php

namespace app\admin\controller;

use adminController\adminController;
use think\Controller;
use app\admin\model\Founder_staff;
use app\admin\model\Founder;
use think\Paginator;

class Staff extends adminController {

    /**
     * 合伙人信息遍历
     * time：18-4-26 10:16
     * author:吴杰
     * @return \think\response\View
     */
    public function index(){

        $data = new Founder_staff();
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $table = $data->To_staff_authorization($start,$limit);
        $tab= $data->To_staff_authorization(0,0);

        $this->assign("limit",$limit);
        $this->assign("count",count($tab));
        $this->assign('data',$table);

        return view('Staff/index');
    }
    public function delete(){
        $id = input('id');
        $data = new Founder();
        $con = $data->deleup($id);
        if($con==0){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 多项删除的操作
     * 吴杰
     * @return bool
     */
    public function delet(){
        $id =explode(",",input('idd'));
        $data = new Founder();
        $con = $data->deleup($id);
        if($con==0){
            return false;
        }else{
            return true;
        }
    }

    public function update(){
        return view('Initiator/update');
    }
    public function updata(){
        return view('Initiator/updata');
    }

    /**
     * 编辑的确认操作
     * @return bool
     */
    public function date(){
        $data=new Founder();
        $id=input("idd");
        $content=input("content");
        $con=$data->adder($id,$content);
        if($con==0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 合伙人页面添加操作的查询
     */
    public function Inidate(){
        $data=new Founder();
        $name=input("name");
        $con=$data->add($name);

        if(empty($con[0])){
            echo json_encode("false");
        }else{
            echo json_encode($con);
        }
    }

    /**
     * 合伙人的授权操作页面
     * 吴杰
     * 2018.4.27
     * @return \think\response\View
     */
    public function impower(){
        $data = new Founder();
        $start = !is_null(input('page')) ? input('page') : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $limit=$limit*$start;
        $start=($start-1)*$limit;

        $table = $data->impower($start,$limit);
        $tab= $data->impower(0,0);

        $this->assign("limit",$limit);
        $this->assign("count",count($tab));
        $this->assign('data',$table);
        return view('Initiator/impower');
    }

    /**
     * 合伙人页面授权通过操作
     * 吴杰
     * 2018.4.27
     * @return bool
     */
    public function imxiu(){

        $data = new Founder();
        $table = $data->imxiu(input("id"));
        if($table==0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 合伙人页面搜索查询
     * 吴杰
     * 2018.4.27
     * @return \think\response\View
     */
    public function select(){

        $data = new Founder_staff();

        $table = $data->selec(input("conten"));
        $this->assign('data',$table);

        return view('Staff/imindex');
    }
}