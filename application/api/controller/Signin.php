<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 9:51
 */

namespace app\api\controller;
use app\api\model\Sign;
use apiController\apiController;

class Signin extends apiController
{
    /**
     * 签到页面签到接口
     * 陈昌海
     * 18.3.31 :16:20
     * 传入用户ID
     */
    public function siglist(){
        $member_id = input('member_id');
        if(!is_null($member_id)){
            $table = new Sign();
            $data = $table->signList($member_id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /**
     * 签到页面接口
     * 陈昌海
     * 18.3.31 :16:20
     * 传入用户ID
     */
    public function sigtime(){
        $member_id=input('post.member_id');
        if(!is_null($member_id)){
            $table = new Sign();
            $data = $table->continuous($member_id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }

    /**
     * 签到成功接口
     * 胡波
     * 18/5/25
     * 传入用户id
     */
    function signSuccess(){
        $member_id=input('post.member_id');
        if(!is_null($member_id)){
            $table = new Sign();
            $data = $table->signSuccess($member_id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }
}