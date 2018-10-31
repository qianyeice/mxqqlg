<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Group_buy;
use app\admin\model\Group_purchase_management;

class GroupPurchaseManagement extends adminController{
    /**
     *团购管理
     * @return \think\response\View
     * 丁龙
     * 18.3.29
     * 13.48
     *
     *数据读取
     * name：龚文凤
     * time：2018/4/10  17:10
     */
    public function index(){
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $pd=input('pd')?input('get.pd'):0;
        $limit = !is_null(input('limit')) ? input('limit') : 20;
        //实例化Group_purchase_management() M层 并调方法
        $tuangouguanli= new Group_purchase_management();


        //查询团购团长身份的用户
        $jg=$tuangouguanli->chaxun($pd,$start,$limit);

        //查询长度
        $view=$tuangouguanli->xianshi($pd);
        $s=count($view);

        //查询团购成员
        $tuanyuan=$tuangouguanli->tuan($pd);

        //多少拼团，以团长身份查询出，在遍历
        $this->assign('sql',$jg);
        //获取数据长度，遍历出来
        $this->assign('count',$s);
        //多少条数据每页，遍历出来
        $this->assign('limit', $limit);
        //团购成员，遍历。
        $this->assign('sl',$tuanyuan);


        return view();
    }

    //手动结束团购
    public function JieShu(){
        //获取页面传过来的标记
        $id=input('id');
        //实例化视图并调用方法
        $sql=new Group_purchase_management();
        $jg=$sql->XiuGaiShiJian($id);
        //判断是否成功
        if ($jg){
             $arr=array(
                'type'=>1,
                'tishi'=>'结束成功'
            );
        }else{
             $arr=array(
                'type'=>0,
                'tishi'=>'结束失败'
            );
        }
        //返回到页面
        return $arr;
    }

}