<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/29
 * Time: 16:04
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\GoodsSku;

class Comspecification extends adminController {
    /**
     * Created by PhpStorm.
     * User: 杜世豪
     * 商品规格
     * Date: 2018/3/29
     * Time: 15:59
     */

    /*
     * 编辑的查询
     */
    public function index(){
        $spuid = input('get.id');

        $data = new GoodsSku();
//        $banana = $data->having($spuid);
        $this->assign('id',$spuid);
        $apple = $data->sel($spuid);
        $this->assign('vo',$apple);
//        $lists = json_decode($apple['spec'],true);
//        $this->assign('voss',$lists);
        return view('index');
    }

    public function adds()
    {
        $id =input('get.id');
        $sn = input('sn');
        $price = input('price');
        $markprice = input('markprice');
        $number = input('number');
        $weight = input('weight');
        $volume = input('volume');
        $fencheng = input('fencheng');
        $data = new GoodsSku();
        $con=$data->add();

//        if(!empty($beef)){
//            $this->redirect('/index.php?s=admin/Comspecification/index&id='.$id);
//        }else{
//            echo '添加失败';
//        }

        return view('index');
    }

    /*
     * 清空规格
     */
    public function dele_ajax()
    {
        $id = input('post.id');
        $wahaha = new GoodsSku();
        $milk = $wahaha->deleajax($id);
        return $milk;
    }

    public function dele_a()
    {
        $id = input('post.id');
        $wahaha = new GoodsSku();
        $milk = $wahaha->deleaj($id);
        return $milk;
    }
}