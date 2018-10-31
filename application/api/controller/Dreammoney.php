<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/3/31
 * Time: 15:40
 */
namespace app\api\controller;
use app\api\model\Get_dream;
use apiController\apiController;

class Dreammoney extends apiController{
    /**
     * 梦想币日志
     * time:2018-3-29 15:43
     * author:李磊
     * @param $id 传入用户id
     * @return $array 返回数据
     */
    public function dreamoney(){
        //$id 获取商品id
        $id = input('id');
        if(!is_null($id)){
            //实例化模型
            $model = new Get_dream();
            //接收数据
            $data = $model->dreammoney($id);
            //返回数据
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }

    }
}