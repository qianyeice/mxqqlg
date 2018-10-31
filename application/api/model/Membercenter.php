<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 2018/7/17
 * Time: 13:02
 */

namespace app\api\model;

use think\Model;

class Membercenter extends Model
{
    /**
     * 龙云飞
     * 得到用户信息
     * @param $userId
     * @return array
     */
    public function getMemberData($userId)
    {

        $data = [
            "userid"=>$userId,//用户id
            "username" => "12154545",//用户名字
            "money" => "123.11",//钱
            "ketimoney" => 123.12,//可提现的钱
            "jifen" => "1234",//积分
            "todayjifen" => "1234",//今日积分
            "yongjin" => "12.12",//佣金
            "todayyongjin" => "12.12",//今日佣金
            "dreammoney" => 123.12,//梦想币
            "fenhong" => "12.12",//分红
            "todayfenhong" => "12.12",//今日分红
        ];
        $array = array();
        if (count($data) > 0) {
            $array["type"] = 1;
            $array["lang"] = 'success';
            $array["data"]=$data;
        } else {
            $array["type"] = 0;
            $array["lang"] = 'notuser';
            $array["data"] = "null";
        }
        return $array;
    }

}