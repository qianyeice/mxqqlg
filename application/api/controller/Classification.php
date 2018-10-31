<?php
/**
 * Created by PhpStorm.
 * User: 浩风
 * Date: 2018/5/8
 * Time: 17:40
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\More_classification;

class classification extends apiController{
    function More(){
        $id=input('id');
        $data=new More_classification();
        $data = $data->category($id);
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
    }
}