<?php
/**
 *   积分明细
 *
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/9
 * Time: 10:12
 */

namespace app\api\controller;

use apiController\apiController;


class Kucun extends apiController{
    /**
     * 商品库存
     * 冯云祥 2018-6-20 10：09
     * @param $spu_id商品id
     * @return array 返回数据
     */
    function index(){
        $spu_id=input("spu_id");
        $new=new \app\api\model\Kucun();
        $data=$new->index($spu_id);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }
}