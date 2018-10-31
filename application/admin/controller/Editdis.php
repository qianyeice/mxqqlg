<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 16:11
 */

namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Distribution;

class Editdis extends adminController
{
    /**
     * 分销角色设置（编辑分销角色）
     * @return \think\response\View
     */
    public function index(){
        //编辑 抓取单条数据
        $id=$_GET['id'];
        $distribution=new Distribution();
        return view()->assign('id',$distribution->distake($id));
    }
    /**
     * time:18-4-10 14.34
     * name:邓剑
     * 编辑 更新数据
     */
    public function ofvalues(){
        $array=input('array/a');
        $id=array_pop($array);
        $distribution=new Distribution();
        return $distribution->disupdata($array,$id);
    }
}