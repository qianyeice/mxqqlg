<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Delivery;

class DistributionLogistics extends adminController{
    /**
     * �������ù���
     *  -4-3 10:16
     * author:������
     */

    public function index()
    {
        $start = !is_null(input('page')) ? input('page')+1: 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $data=new Delivery();
        $count=$data->query();
        $name=$data->querys($start,$limit);
        $this->assign("limit",$limit);
        $this->assign("count",count($count));
        $this->assign('name',$name);
        return view();
    }
    //删除数据
    public function deletes(){
        $data=new Delivery();
        $array=$data->deletes(input('id'));
        return $array;
    }
}