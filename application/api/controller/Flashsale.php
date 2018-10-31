<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12 0012
 * Time: 16:16
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Promotion_commodity;
use app\api\model\Xianshiqianggou;

class Flashsale extends apiController {
    public function index(){
        $pro=new Promotion_commodity();
        $data=$pro->index();
        $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
        return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
//        return $data;
//      return $this->apiReturn($data["type"],$data["lang"],$data["data"]);
    }

// 现实抢购详情内容 app
    public function xianshi(){
        $pid=input("pid");
        $xian=new Xianshiqianggou();
        $data=$xian->index($pid);
        return $data;
    }
    public function xian(){
        $pid=input("pid");
        $xian=new Xianshiqianggou();
        $data=$xian->shi($pid);
        return $data;
    }
// 现实抢购详情内容 weixin
    public function xianshopp(){
        $id=input("id");
        if(!is_null($id)){
            $xian=new Xianshiqianggou();
            $data=$xian->xian($id);
            $this->apiJournal($data["type"],$data["lang"],$data["data"]);//日志
            return $this->apiReturn($data["type"],$data["lang"],$data["data"]);//返回格式
        }else{
            return $this->apiReturn(0,lang('faileds'),'');//返回格式

        }
        return $data;


    }

    public function news(){
        $id=input("id");
        $xian=new Xianshiqianggou();
        $data=$xian->news($id);
        return $data;
    }

//    public function shopp(){
//        $id=input("id");
//        $pro=new Promotion_commodity();
//        $data=$pro->shopping($id);
//        return $data;
//    }

}