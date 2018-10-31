<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\29 0029
 * Time: 15:49
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Reply;
use think\Controller;

class Evaluationprojectile extends adminController
{
    /*
     * Evaluationlist的iframe框
     * 查看
     */
    public function index()
    {
        $id = input('get.id');
        
        $this->assign('vo',$id);
        return view();
    }

    public function eval_ajax()
    {
        $id = input('post.id');
        $reply = input('post.reply');
        $ply = new Reply();
        $apples = $ply->adds($id,$reply);
        return $apples;
    }

}
