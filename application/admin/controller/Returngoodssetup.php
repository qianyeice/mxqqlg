<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/4/2
 * Time: 13:13
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Site_returngoods;

class Returngoodssetup extends adminController{
    /**
     *退货设置
     * @return \think\response\View
     */
    public function index()
    {
        $ret=new Site_returngoods();
        return view('index')->assign('ret',$ret->retall());
    }
    /**
     * time:18-4-12 10.03
     * name:邓剑
     * 站点设置 退货设置 更新
     */
    public function siteupdata(){
        $selected=input('selected');
        $array=input('array/a');
        array_unshift($array,$selected);
        $id=array_pop($array);
        $phone = "/^1[34578]\d{9}$/";
        if(preg_match($phone,$array[3])){
            $ret=new Site_returngoods();
            return $ret->retupdata($id,$array);
        } else {
            return [
                'type' => '0',
                'explain' => '手机号码格式错误！'
            ];
        }
    }
}