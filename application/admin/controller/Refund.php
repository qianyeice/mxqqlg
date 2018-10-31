<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\29 0029
 * Time: 13:39
 */
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\ViewRefund;

class Refund extends adminController
{
    /**
     * 退款单管理
     * 程建2018-4-7 11:24
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
//        实例化ViewRefund
        $data=new ViewRefund();
        $search=input('get.val');
        $start = !is_null(input('page')) ? input('page') : 0;
        $limit = !is_null(input('limit')) ? input('limit') : 5;
        //        判断get，val值是否存在，
        if(isset($search)){
            $val=$data->refund_search($search,$start,$limit);
            $count=$val['data']['count'];
            unset($val['data']['count']);
        }else{
            //        获取URL传值type处理，没处理，全部
            $type=input('get.type')?input('get.type'):3;
            //        传递获取对应类型数据
            $val=$data->refund_manage($type,$start,$limit);
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
