<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/3/29
 * Time: 17:01
 */
namespace app\admin\controller;

use adminController\adminController;
use app\admin\model\Detasetting;
use app\admin\model\Skugoods;

/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * 编辑
 * Date: 2018/3/29
 * Time: 9:59
 */
class Detailsetting extends adminController {

    /**
     * 商品列表--详情设置  重写
     * 吴杰
     * 2018.5.22
     * @return \think\response\View
     */
    public function  init(){
        $id=input('id');
        $beef = new Skugoods();
        $app = $beef->selet($id);
        $this->assign('vo',$app);
        return view();
    }

    /**
     * 内容保存
     * 吴杰
     * 2018.5.22
     */
    public function add(){
        $id=input('id');
        $count = input('post.editorValue');
        $beef = new Skugoods();
        $app = $beef->add($id,$count);
        if($app>0){
            echo "<script>alert('编辑成功！');location.href='?s=admin/Commodityvideo/index&id='+$id</script>";
        }else {
            echo "<script>location.href='?s=admin/Commodityvideo/index&id='+$id</script>";
        }
    }
//    public function init(){
//        $id = input('get.id');
//        $prs = input('post.editorValue');
//
//        $data = new Detasetting();
////        $apple = $data->sel($id);
////        $this->assign('vo',$apple);
//
//        if($_POST){
//            $prs = input('post.editorValue');
//            dump($prs);
//
//            $beef = new Detasetting();
//            $pears = $beef->upsave($id,$prs);
//        }
//        return view();
//    }


//    public function adds()
//    {
//        $id = input('get.id');
//        if($_POST){
//            $prs = input('post.editorValue');
//            dump($prs);
//
//            $beef = new Detasetting();
//            $pears = $beef->upsave($id,$prs);
//        }
//
//        return view('init');
//    }
}