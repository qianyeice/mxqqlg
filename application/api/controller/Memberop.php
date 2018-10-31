<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 2018/3/27
 * Time: 17:10
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Member_op;

class Memberop extends apiController{
    /**
     * 侯智
     * 判断该微信用户是否注册
     */
    public function openid(){
        $openid=input("openid");
        $boj=new Member_op();
        $data=$boj->seopenid($openid);
        if($data){
            header("location:http://cg.mxqqlg.com/?s=index/index/zhuye");
        }else{
            header("location:http://cg.mxqqlg.com/?s=index/index/zhuce&openid=".$openid);
        }
    }
}