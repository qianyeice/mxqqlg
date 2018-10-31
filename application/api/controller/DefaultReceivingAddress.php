<?php
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Member_address;
use  think\model;
class DefaultReceivingAddress extends apiController
{
    /**
     * 提交订单页面默认收货地址
     * 丁龙
     * 18.3.20 :12:20
     * 传入用户ID
     */
    public function index()
    {
        $id=input('post.id');
        if(!is_null($id)){
            $model=new Member_address();
            $data=$model->ReceivingAddress($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}
