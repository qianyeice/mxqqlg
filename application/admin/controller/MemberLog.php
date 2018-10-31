<?php
/**
 * Created by PhpStorm.
 * User: yue
 * Date: 2018/3/29
 * Time: 14:16
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\MemberLog_data;
use app\admin\model\View_member_member_log;

class MemberLog extends adminController
{
    //余额管理 列表
    public function lists()
    {
        $data=new MemberLog_data();
        $array=$data->Query_data();
        $this->assign('count',count($array[0]));
        $this->assign('data',$array[0]);
        return view();
    }
    function the_query_time(){
        dump($_POST);
    }

    function init(){
        $end=input('end_time');
        $begin=input('begin_time');
        $name=input('hui');
        $data=new View_member_member_log();
        $data=$data->sel($name,$begin,$end);
        return $data;
    }
}
