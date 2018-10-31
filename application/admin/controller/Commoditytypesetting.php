<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 15:34
 */
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Spec;
use app\admin\model\Type;
use app\admin\model\Barnd;

/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * 商品类型设置
 * Date: 2018/3/29
 * Time: 9:59
 */
class Commoditytypesetting extends adminController {
    public function index(){
//        $bat = new Spec();
//        $banana = $bat->selects();
//
//        $this->assign('ban',$banana);

        $id = input('get.id');

        $set = new Type();
        $beef = $set->sel($id);
        $this->assign('vo',$beef);

        $bat = new Spec();
        $banana = $bat->selects();
        $this->assign('ban',$banana);

        return view('init');
    }

    public function save_ajax()
    {
        $id = input('post.id');
        $name = input('post.name');
        $status = input('post.status');
        $spec_id = input('post.spec_id');
        $text = input('post.text');
        $a=new Type();
        $a->adds($id,$name,$status,$spec_id,$text);

    }
    public function init(){

        echo 666;
        $bat = new Spec();
        $banana = $bat->selects();
        $this->assign('ban',$banana);
        return view();
    }

    public function news()
    {

    }

    public function upsave()
    {
//        $bat = new Spec();
//        $banana = $bat->selects();
//        $this->assign('ban',$banana);
//
//        $id = input('get.id');
//        $set = new Type();
//        $beef = $set->sel($id);
//        $this->assign("arr",explode(",",$beef["specid"]));
//        $this->assign('vo',$beef);
//        return view('init');

        $id = input('post.id');
        $name = input('post.name');
        $status = input('post.status');
        $spec_id = input('post.spec_id');
        $text = input('post.text');

        var_dump($name);


        return view();
    }

    /**
     * @return bool
     * User: 李天
     * 商品类型删除
     * Date: 2018/5/4
     * Time: 11.09
     */
    public function delete(){

//        echo 666;
//        exit;
        $id = input('get.id');

        var_dump($id);

        $data = new Barnd();
        $con = $data->deleall($id);
        var_dump($con);
        exit;
        if($con==0){
            return false;
        }else{
            return true;
        }
    }

}