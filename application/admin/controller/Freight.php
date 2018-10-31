<?php
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Freight_query;

class Freight extends adminController{
    public function index(){
        $data=new Freight_query();
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $count=$data->query();
        $array=$data->querys($start,$limit);
        $this->assign("limit",$limit);
        $this->assign("count",count($count));
        $this->assign('array',$array);
        return view('freight/index');
    }
    public function deletes(){
        $data=new Freight_query();
        $array=$data->deletes(input('id'));
        return $array;
    }
    public function batch_delete(){
        $data=$_POST;
        $id_array=$data['array'];
        $lenght=$data['lenghts'];
        $array=new Freight_query();
        return $array->batch_delete($id_array,$lenght);
    }

}