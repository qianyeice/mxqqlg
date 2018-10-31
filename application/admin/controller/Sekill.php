<?php
namespace app\admin\controller;
use adminController\adminController;
use app\admin\model\Promotion_commodity_seckill;
use app\admin\model\Promotion_commodity;
use app\admin\model\Promotion_commodity_relation;

/**
 * 秒杀
 * name:张平
 * time:2018 03 29 14:25
 * Class Sekill
 * @package app\admin\controller
 */

class Sekill extends adminController
{
    /**
     * 数量查询
     * @param $moder 实例化模型
     * @param $number/$lists接收返还数据
     * @return
     * name 岳军章
     * time 2018/4/21 14:00
     */
   public function index()
    {

       $moder = new Promotion_commodity_seckill();
        //数据数量

        //数据列表
        $number = $moder->lists_number();
        $this->assign('count', $number);

        $start = !is_null(input('page')) ? input('page')+1 : 1;
        $limit = !is_null(input('limit')) ? input('limit') : 20;

        // 传递获取对应类型数据
        $select=$moder->lists($start,$limit);

        $this->assign('lists', $select);
        $this->assign('limit', $limit);
        return view();


    }


    /**
     * 删除
     * @param $moder 实例化模型
     * @param $id 获取id
     * @return
     * name 岳军章
     * time 2018/4/21 14:30
     */

    public function delete()
    {
        $id =explode(",",input('id'));
        $commodity = new Promotion_commodity();
        $relation  = new Promotion_commodity_relation();
        $date=$commodity->dele($id);
        $data=$relation->fdele($id);

        if($date==true && $data==true){
            return true;
        }else{
            return false;
        }

    }

}