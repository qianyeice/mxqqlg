<?php
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\SkuSpec;
use app\admin\model\Spec;

class Productspecifications extends adminController {
    /**
     * 商品规格 - 商品列表
     * time:18-3-29 16.55
     * name:邓剑
     * @return \think\response\View
     */
    public function index(){
        $data = new Spec();
        $table = $data->read();
        $this->assign('data',$table);

        return view('index');
    }

    /**
     * 商品规格——删除
     * 陈昌海 2018-4-10 11:24
     */
    public function dele()
    {
        $id = input('post.id');
        dump($id);

        $da = new Spec();
        $data = $da->deleup($id);

    }
}