<?php
/**
 * Created by PhpStorm.
 * User: 杜世豪
 * Date: 2018/3/29
 * Time: 16:19
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Skugoods;
class Commodityvideo extends adminController {
    /**
     * 吴杰
     * 商品列表--视频
     * 2018.5.22
     * @return \think\response\View
     */
    public function index(){
        $id = input('id');
        $beef = new Skugoods();
//        $apple = $beef->sel($id);
        $app = $beef->selet($id);
        $this->assign('vo',$app);
        return view('index');
    }
}