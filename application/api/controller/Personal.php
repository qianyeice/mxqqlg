<?php
/**
 * 个人资料接口
 *
 *
 * Created by PhpStorm.
 * User: 付建军
 * userID：用户ID
 * Date: 2018/5/11
 * Time: 10:16
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\Personal_data;
class personal extends apiController{
    function data(){
        $id = input("post.userID");
        if(!is_null($id)){
            $data = new Personal_data();
            $data = $data->Personaldata($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

}