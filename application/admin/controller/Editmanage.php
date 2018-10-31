<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4
 * Time: 11:37
 */

namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Distribution;

class Editmanage extends adminController
{
    /**
     * 分销角色设置（分销角色管理）
     * @return \think\response\View
     */
    public function index()
    {
        $distribution = new Distribution();
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $data=$distribution->disall($start,$limit);
        $this->assign("limit",$limit);
        $this->assign("count",count($data));
        $this->assign("data",$data);
        return view();
    }

    /**
     * time:18-4-10 14.34
     * name:邓剑
     * 删除
     */
    public function eddelete()
    {
        $id = input('id');
        $distribution = new Distribution();
        $data = $distribution->disdele($id);
        return $data;
    }
}