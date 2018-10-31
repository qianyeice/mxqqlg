<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\ViewExpress;

class Orderexpresssingle extends adminController {
    /**
     * 订单 - 快递单管理
     * time:18-3-29 16.55
     * name:邓剑
     * @return \think\response\View
     */
    public function index(){
//        实例化ViewRefund
        $data=new ViewExpress();
//        获取URL传值type处理，没处理，全部
        $type=input('get.type')?input('get.type'):0;
        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') : 10;
//        传递获取对应类型数据
        $val=$data->express($type,$start,$limit);
        $count=$val['data']['count'];
        unset($val['data']['count']);
//        向页面传递参数
//        return $val;
        $this->assign('val',$val);
        $this->assign('count', $count);
        $this->assign('limit', $limit);
        return view();
    }
}