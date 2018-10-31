<?php
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\GoodSpu;
use app\admin\model\ProductList;
use app\api\model\GoodsSpu;

class Productinventory extends adminController {
    /**
     * 商品列表 - 库存警告
     * time:18-3-29 16.55
     * name:邓剑
     * @return \think\response\View
     */
    public function index()
    {
        //$ints = input('post.notice');
        $ints = 5;
        $data = new ProductList();
        $tables=$data->proinventory($ints);

        $this->assign('data',$tables);

        return view('index');
    }

    public function apple()
    {
        //$id=input('id');
$id = 1;
        $data = new GoodsSpu();
        $table = $data->nowsgoods($id);
dump($table);

        return $table["lang"];

    }

    /**
     * 库存警告删除
     * 吴杰
     */
    public function delete(){
        $id =explode(",",input('id'));
        $data = new ProductList();
        $tables=$data->delet($id);
        if($tables>0){
            return true;
        }else{
            return false;
        }
    }
}