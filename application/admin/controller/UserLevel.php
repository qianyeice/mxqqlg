<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 13:42
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Member_group;
use app\admin\model\Userlevels;
use think\Db;

/**
 * Class UserLevel
 * @package app\admin\controller 渲染用户等级页面
 * name：龚文凤
 *time:2018.3.29 13：45
 */
class UserLevel extends adminController{
    function index(){
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $data=new Userlevels();
        $tab= $data->query_data();
        $this->assign("limit",$limit);
        $this->assign("count",count($tab));
        $query_data=$data->query($start,$limit);
        if($query_data==lang('noData')){
            echo lang('noData');
        }else{
            $this->assign('data', $query_data);
//            dump($query_data);
            return view();
        }
    }

    function delect(){
        $id =explode(",",input('id'));
        $data=new Member_group();
        $data=$data->del($id);
        return $data;
    }

}