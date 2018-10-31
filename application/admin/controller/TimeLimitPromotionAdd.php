<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 14:33
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Promotion_commodity;
use app\admin\model\Promotion_commodity_relation;
use think\facade\Request;
use think\Db;
class TimeLimitPromotionAdd extends adminController{

    private $state=0;
    /**
     * 限时促销添加管理
     * time：18-3-29 14:16
     * author:蒲胜平
     * @return \think\response\View
     */
    public function TimeLimitPromotionAdd(){
         $pro=new Promotion_commodity();
        return view();
    }
//添加
    public function promotion_Add(){
        $prod=input();

//        实例化，添加活动
        $data=new  Promotion_commodity();
        $val=$data->time_activity_add($prod);
        return $val;

    }
}