<?php
namespace app\api\controller;
//use app\api\model\Member_address;
use apiController\apiController;
use app\api\model\Config;

/**
 * 易婷婷
 * 首页通知
*/
class Shouytongzhi extends apiController{

     public function tongzhi(){
         $data = new Config();
         $data = $data->tong();
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
     }
}