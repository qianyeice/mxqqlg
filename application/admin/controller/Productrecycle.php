<?php
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ProductList;

class Productrecycle extends adminController {
    /**
     * 商品列表 - 回收站
     * time:18-3-29 16.55
     * name:邓剑
     * @return \think\response\View
     */
    public function index(){
        $data = new ProductList();
        $table = $data->prorecycle();

        $this->assign('data',$table);
        return view('index');

    }

    /**
     * 回收站恢复操作
     * 吴杰
     */
    public function live(){
        $id=input("id");
        $data = new ProductList();
        $table = $data->live($id);
        if($table>0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 回收站删除操作
     * 吴杰
     * @return bool
     */
    public function delet()
    {
        $id =explode(",",input('id'));
        $data = new ProductList();
        $tables = $data->delett($id);
        if($tables>0){
            return true;
        }else{
            return false;
        }
    }
}