<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Promotion_groupbuy;

class GroupPurchasePromotion extends adminController{
    /**
     * 团购促销
     * @return \think\response\View
     * 丁龙
     * 18.3.29
     * 13.48
     *
     * 数据传输：
     * name：龚文凤
     * time：2018/4/8 14：47
     */
    public function index(){
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') :20;
//        $page = input('get.page') ? input('get.page') : 0;
//        $page = ceil(($page) * 10);
        //实例化Promotion_groupbuy() 数据库
        $tuangou=new Promotion_groupbuy();
        $tgcx=$tuangou->TuanGouChaXun($start,$limit);
//        $tgcx=$tuangou->TuanGouChaXun(3,2);
        //总数
        $con=$tuangou->cou();
        //向页面传递参数
//        $this->assign('page', $page);
//        $tgcx=$tuangou->TuanGouChaXun($start,1);
        $this->assign('sql', $tgcx);
        $this->assign('limit',$limit);
        $this->assign('count',$con);
        return view();

    }
    //删除
    public function shanchu(){
        $id=input('post.id/a');

        $tuangou=new Promotion_groupbuy();

        $tgcx=$tuangou->shanchu($id[0]);
        if ($tgcx==1){
            return array(
              'type'=>1,
              'data'=>'删除成功'
            );
        }else{
            return array(
                'type'=>0,
                'data'=>'未知错误'
            );
        }

    }

    public function test(){
//        $id=input('post.id/a');
//        $username=$_POST['name'];
        $id=$_POST['id'];
        $tuangou=new Promotion_groupbuy();
        $tgcx=$tuangou->shanchu($id);
        if ($tgcx==1){
            echo  '删除成功'.$id;
        }else{
            echo '删除失败';
        }

    }


}