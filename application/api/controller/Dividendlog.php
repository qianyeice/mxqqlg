<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/3/31
 * Time: 15:11
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Dividend_log;
class Dividendlog extends apiController{
    /**
     * 分红日志
     * 冯云祥
     * 传入用户ID
     */
    public function A_bonus(){
        $id=input('id');
        if(!is_null($id)){
            $model=new Dividend_log();
            $data=$model->dividendlog($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }

    }
}