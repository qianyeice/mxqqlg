<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/24
 * Time: 16:21
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\GetIntegral;

class Memberdayintegral extends apiController{
    /**
     * 查询今日总积分
     * 程建2018-3-24 17:58
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function get_day_integral(){
        //        接入传入id
        $userId = input("userID");
        if(!is_null($userId)){
            //   实例化Member
            $data = new GetIntegral();
            //        引用dmember_assets方法
            $data = $data->day_integral($userId);
            //        调用返回数据
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}