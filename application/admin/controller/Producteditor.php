<?php
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Spec;
use think\Env;
use think\facade\Request;
class Producteditor extends adminController {
    /**
     * 商品规格 - 添加编辑商品规格
     * time:18-3-29 16.55
     * name:邓剑
     * @return \think\response\View
     */
    public function index(){

        return view('index');
    }

    /**
     * 添加和修改商品规格
     */
    public function sean_ajax(){
        $id = input('post.id');
        $data['name'] = input('post.name');
        $data['status'] = input('post.status');
        $data['value'] = input('post.value');

        $tabl = new Spec();
        $pears = $tabl->adds($id,$data);

        //dump($pears);

    }


    /**
     * 编辑商品规格
     */
    public function sele()
    {
        $id = input('get.id');

        $kou = new Spec();
        $banana = $kou->sel($id);
        $this->assign('vo',$banana);
        
        return view('index');
    }


}