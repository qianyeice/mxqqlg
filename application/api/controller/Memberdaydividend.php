<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 9:59
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\DividendLog;

class Memberdaydividend extends apiController{
    /**查询今日总分红
     * 程建 2018-3-27 9:59
     * @return array 返回今天总分红
     */
    public function get_day_dividend(){
        //        接入传入id
        $userId = input("userID");
        if(!is_null($userId)){
            $data = new DividendLog();
            //        引用day_dividend方法
            $data = $data->day_dividend($userId);
            //        调用返回数据
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}