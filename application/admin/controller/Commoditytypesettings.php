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
use think\Session;

/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * 商品类型设置
 * Date: 2018/3/29
 * Time: 9:59
 */
class Commoditytypesettings extends adminController {
    public function index(){
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
        $bat = new Spec();
        $banana = $bat->selects();
        $this->assign('ban',$banana);
        return view();
    }

    public function upsave()
    {

        $id = input('post.id');
        $name = input('post.name');
        $status = input('post.status');
        $spec_id = input('post.spec_id');
        $text = input('post.text');

        $up=new Type();
        $up->newsave($id,$name,$status,$spec_id,$text);


    }

    /**
     * @return bool
     * User: 李天
     * 商品类型删除
     * Date: 2018/5/4
     * Time: 11.09
     */
    public function delete(){
        $id = input('get.id');

        $data = new Barnd();
        $con = $data->deleall($id);
        if($con==0){
            return false;
        }else{
            return true;
        }
    }

}