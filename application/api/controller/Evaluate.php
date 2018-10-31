<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\20 0020
 * Time: 14:22
 */
namespace app\api\controller;
use https\curl;
Class Evaluate extends Evaluationpage {
    /*
     * @param $member_id:用户id
     * @param $spu_id:商品id
     *  @param $order_id:订单id
     * 评价页面判断已评价或者未评价
     * Time: 2018\3\20  14:55 name：白锦国
     */
    public function Judge(){
        $member_id=input('post.id');
        $spu_id=input('post.spu_id');
        $order_id=input('post.order_id');
        $data=new \app\api\model\Evaluate();
        $datas=$data->Judge($member_id,$spu_id,$order_id);
        return $datas;
    }
}