<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 16:34
 */

namespace app\api\controller;
use apiController\apiController;
use \app\api\model\Commission;
class Mycommission extends apiController
{
    /***
     * @return array
     * 我的佣金
     * 胡焱
     */

    public function get_dist()
    {
        $member_id = input('member_id');
        $type = input('type');
        if(!is_null($member_id) && !is_null($type)){
            $dis = new Commission();
            $data = $dis->dist($member_id,$type);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }

    }


}