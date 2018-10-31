<?php
/**
 * 大转盘物品的概率和物品信息
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/25
 * Time: 15:08
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Proba;

class probability extends apiController{
    /**
     * @return array
     */
    function proba_bility(){
        $lottery_id=input('probabilityid');
        $data=new  Proba();
        $val = $data->bility($lottery_id);
        return $this->apiReturn($val["type"], $val["lang"], $val["data"]);
    }
}