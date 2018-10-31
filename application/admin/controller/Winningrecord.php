<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/27
 * Time: 10:12
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Lottrey_login;
class Winningrecord extends adminController{
    /**
     * 抽奖活动中奖纪录遍历
     * 吴杰
     * 2018.5.3
     * @return \think\response\View
     */
    public function index(){

        $data = new Lottrey_login();
//        $data=$data->Journal('1','2');
//        dump($data);
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
        $table = $data->Journal($start,$limit);
        $tables = $data->Jour();
        $this->assign("limit",$limit);
        $this->assign("count",count($tables));
        $this->assign('data',$table);
        $this->assign('title',input("id"));
        return view('Winningrecord/index');

    }


    /**
     * 根据条件查询用户中奖信息
     * 吴杰
     * @return \think\response\View
     */
    public function selec(){

        $username=input("username");
        $mobile=input("mobile");
        $username = !empty($username) ? $username :0;
        $mobile = !empty($mobile) ? $mobile :0;

        $data = new Lottrey_login();
        $table = $data->seler($username,$mobile);
        $this->assign('data',$table);

        return view('Winningrecord/select');
    }
    /**
     * 抽奖活动中未发放奖品发放操作
     * 吴杰
     * 2018.5.2
     */
    public function delet(){
        $id=input("id");
        $data = new Lottrey_login();
        $cont=$data->delet($id);

        if($cont>0){
            return true;
        }else{
            return false;
        }
    }
}
