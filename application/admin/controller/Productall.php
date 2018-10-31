<?php
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\ProductList;

class Productall extends adminController
{
    /**
     * 商品规格 - 全部商品
     * time:18-3-29 16.55
     * name:邓剑
     * @return \think\response\View
     */
    public function index()
    {
        $data = new ProductList();

        $start =(input('page')) ? input('page') + 1 : 0;
        $limit =(input('limit')) ? input('limit') : 20;
        $apple = $data->brand();
        $fenlei = input('catid');
        $barnd = input('barnd');
        $keyword =input('keyword');
        $lable = input('lable')?input('lable'):'1';
        $table = $data->product($lable, $fenlei, $barnd, $keyword, $start, $limit);
        $this->assign('limit', $limit);
        $this->assign('data', $table['data']);
        $this->assign('count', count($table['count']));
        $this->assign('brand', $apple);
        $this->assign('lable',$lable);
        return view('index');
    }


    public function offshelf()
    {
        $start = !is_null(input('page')) ? input('page') + 1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') : 20;
        $data = new ProductList();
        $apple = $data->brand();
        if ($_POST) {
            $fenlei = input('fenlei');
            $barnd = input('barnd');
            $keyword = input('keyword');
            $tables = $data->shelfoff($fenlei, $barnd, $keyword);
        } else {
            $tables = $data->product_lists($start, $limit);
        }
        $tables = $data->shelfoff();
        $this->assign('data', $tables);
        $this->assign('data_length', count($tables));
        $this->assign('count', $tables);
        $this->assign('brand', $apple);
//        exit;
        return view('index');
    }

    public function delet()
    {
        $id = explode(",", input('id'));
        $data = new ProductList();
        $tables = $data->delet($id);
        if ($tables > 0) {
            return true;
        } else {
            return false;
        }
    }
}