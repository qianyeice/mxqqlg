<?php

namespace app\api\controller;

use apiController\apiController;
use app\api\model\Paison_relation;
use app\api\model\Member;

class RedPacketDelivery extends apiController
{
    /**
     * 红包派送接口
     * @return array
     * 丁龙
     * 18.3.27
     * 17:05
     */
//    public function Redpacketdelivery()
//    {
//        $pid = input('post.pid');
//        $jid = input('post.jid');
//        $mod = new Paison_relation();
//        $arr=$mod->red($pid, $jid);
//       return $this->apiReturn($arr['type'],$arr['lang'],$arr['data']);
//    }
    /**
     * 红包派送接口重写
     * 张帅
     * @return array
     */
    public function Redpacketdelivery()
    {
        $id = input('id');
        $mod = new Paison_relation();
        $arr=$mod->red($id);
        return $this->apiReturn($arr['type'],$arr['lang'],$arr['data']);
    }

    /**
     * 现金红包完成任务的用户信息
     * @return array
     */
    public function Redpack()
    {
        $id = input('numb');
        $con=explode(',',$id);
        $mod = new Paison_relation();
        $arr=$mod->reder($con);
        return $this->apiReturn($arr['type'],$arr['lang'],$arr['data']);
    }

    /**
     * 现金红包现金领取
     */
    public function Savereder(){
        $id=input('id');
//        $money=input('money');
        $data=new Member();
        $arr=$data->savered($id);
        return $this->apiReturn($arr['type'],$arr['lang'],$arr['data']);
    }
    /**
     * 获取帮助完成任务的人的信息
     * 张帅
     * @return array
     */
    public function msg(){
        $id = input('post.id');
        $array = explode(",",$id);
        $mod = new Member();
        $arr = $mod->get_msg($array);
        return $this->apiReturn($arr['type'],$arr['lang'],$arr['data']);
    }

    /**
     * 判断用户是否领取过红包
     */
    public function complete(){
        $id = input('post.id');
        $mod = new Paison_relation();
        $arr = $mod->_complete($id);
//        require $this->apiReturn($arr['type'],$arr['lang'],$arr['data']);
        return $this->apiReturn($arr['type'],$arr['lang'],$arr['data']);
    }

    /**
     * 判断用户是否完成红包任务
     */
    public function redtask(){
        $id = input('post.id');
//        $id = 3381;
        if(!is_null($id)){
            $data = new Paison_relation();
            $data = $data->redtasks($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }

    }


//    新手红包任务完成后数据写入数据库
    public function readred(){
        //报错原因：前端没传值，前端传值，或给个固定值即可查看
        $id = input('id');
        $money =input('money');
        if(!is_null($id) && !is_null($money)){
            $data = new Paison_relation();
            $data = $data->readreds($id,$money);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }




//    app个人中心账户余额充值后写入数据库
    public function wxaddmoney(){
        $uid = input('uid');
        $money =input('money');
        if(!is_null($uid) && !is_null($money)){
            $data = new Paison_relation();
            $data = $data->appaddmoney($uid,$money);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'));//返回格式
        }
    }



}