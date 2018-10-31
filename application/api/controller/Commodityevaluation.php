<?php
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Evaluation;

class Commodityevaluation extends apiController
{
    /**
     * 商品详情页面评价列表
     * 胡焱
     * 2018-5-10
     */
   function word(){
       //$data['userID'] = input("post.userID");
       $spu_id = input("post.spu_id");
       if(!is_null($spu_id)){
           $res=new Evaluation();
           $data = $res->comm_eval($spu_id);
           $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
           return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
       }else{
           return $this->apiReturn(0,lang('faileds'));//返回格式
       }
   }

}
