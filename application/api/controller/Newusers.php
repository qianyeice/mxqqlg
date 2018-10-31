<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/29 0029
 * Time: 17:58
 */

namespace app\api\controller;
use apiController\apiController;
use app\api\model\Member;
use app\api\model\Order;

class Newusers extends apiController {
    public function index(){
        $member_id=input("member_id");
        $or=new Order();
        $me=new Member();
        $data=$or->NewPeople($member_id);
        $parent_id=$me->getParentid($member_id);
        if(!$parent_id["parent_id"]){
            $parent_id["parent_id"]=0;
        }
        if(!$data["data"]){
            return $me->quesu($member_id,$parent_id["parent_id"]);
        }else{
            return "olduser";
        }
    }
}