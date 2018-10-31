<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Admin_red;

class Adminred extends adminController{
    /**
     * 礼包红包管理
     * time：18-4-12 09:48
     * author:蒲胜平
     */
    public function index()
    {
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $hb=new Admin_red();
        //查询数据库总数
        $chuan=$hb->admin_red();
        //框架自带分页查询
        $page=$hb->dapage($start,$limit);
        //每页显示数目
        $this->assign('limit',$limit);
        //每页显示的东西
        $this->assign('hb',$page);
        //传查询数据库总数
        $this->assign('count',$chuan);
        return view();
    }

    public function u(){

    }
}