<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 15:39
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Spec;

class Tankuangkuangguigui extends adminController {
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * 编辑添加商品规格
     * Date: 2018/3/29
     * Time: 15:59
     */
    public function index()
    {
        $id =input('get.id');

        $dis = new Spec();
        $pears = $dis->selects();

        $this->assign('data',$pears);
        $this->assign('spuid',$id);


        return view('index');
    }


    public function spec_ajax()
    {
        $kuang = input('post.');
        $data = input('post.name');

        $beef = new Spec();
        $apple = $beef->spajax($data);
    }

//    js的添加第二步1
    public function spectwo_ajax()
    {
        $angs = input('post.');
        $id = input('post.id');
        $banana = new Spec();
        $pears = $banana->sel($id);
        return $pears;
    }

//    js的添加第二步2
    public function specer_ajax()
    {
        $id = input('post.id');

        $per = new Spec();
        $bana = $per->deleup($id);
        return $bana;
    }

//    js第四步
    public function specfour_ajax()
    {
        $four = input('post.');
        $fourid = input('post.id');
        $fourval = input('post.value');

        $ourf = new Spec();
        $leapp = $ourf->spfourajax($fourid,$fourval);
        return $leapp;
    }

//    生成
    public function okbtn_ajax()
    {
        $id = input('post.id');
        $spec = input('post.spec');

        $wahaha = new Spec();
        $milk = $wahaha->okbtn_ajax($id,$spec);

        return $milk;
    }
}