<?php
namespace app\api\controller;
use app\api\model\Refund;
use apiController\apiController;

/**
 * Class Tuikuanjk
 * @package app\api\controller
 * 易婷婷
 */
class Tuikuanjk extends apiController{
    /**
     * @return array
     * 判断是否已经退款接口
     */
    public function panduantuikuan(){
        $order_id = input('post.order_id');
        $mid=input('post.id');
        $model = new Refund();
        $rlst = $model->tkchankan($mid,$order_id);
        return $this->apiReturn($rlst["type"],$rlst["lang"],$rlst["data"]);
    }



}