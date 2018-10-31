<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\29 0029
 * Time: 13:39
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Reply;
use think\Controller;

class Evaluationlist extends adminController
{
    /*
     * 评论列表
     */
    public function index()
    {
        $let = new Reply();
        $pears = $let->sel();
        $this->assign('pears',$pears);

        return view();
    }

    /*
     * 评论列表的删除
     */
    public function dele()
    {
        $id =explode(",",input('id'));
        $ele = new Reply();
        $lua = $ele->dele($id);
        if($lua){
            return true;
        }else{
            return false;
        }
    }

    public function search()
    {
        $starttime = input('post.starttime');
        $endtime = input('post.endtime');
        $keyword = input('post.keyword');
        $spinner = input('post.spinner');
//        $start=strtotime($starttime);
//        $end=strtotime($endtime);
        $let = new Reply();
        $pears = $let->search($starttime,$endtime,$spinner,$keyword);
        $this->assign('pears',$pears);
        return view("index");
    }

}
