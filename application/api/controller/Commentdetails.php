<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\3\24 0024
 * Time: 14:34
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Comment_details;

Class Commentdetails extends apiController{
    /**
     * 商品评价页面，评价信息
     * @param $order_id:已评论的订单id
     * Time: 2018\3\24  14:37 name：白锦国
     */
    function Method(){
    $spu_id=input('post.spu_id');
    $data=new Comment_details();
    return $data->Method($spu_id);
    }
}