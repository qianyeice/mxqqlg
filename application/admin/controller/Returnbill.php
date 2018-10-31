<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\ViewRefund;

class Returnbill extends adminController
{

    /**
     * 退货单管理
     * 程建 2018-4-7 11:37
     * @return \think\response\View
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
//        实例化ViewRefund
        $data=new ViewRefund();
        $search=input('get.val');
        $start = !is_null(input('page')) ? input('page')+1: 1;
        $limit = !is_null(input('limit')) ? input('limit') : 5;
        if(isset($search)){
            $val=$data->return_goods_manage($search,$start,$limit);
            $count=$val['data']['count'];
            unset($val['data']['count']);
        }else{
            //        获取URL传值type处理，没处理，全部
            $type=input('get.type')?input('get.type'):3;
            //        传递获取对应类型数据
            $val=$data->return_goods_manage($type,$start,$limit);
            $count=$val['data']['count'];
            unset($val['data']['count']);
        }

//        向页面传递参数
        $this->assign('val',$val);
        $this->assign('count', $count);
        $this->assign('limit', $limit);
        return view();
    }
}