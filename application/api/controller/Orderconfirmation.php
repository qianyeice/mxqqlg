<?php
/**
 * Created by PhpStorm.
 * User: 酷炫的勇哥
 * Date: 2018/3/27
 * Time: 18:09
 */
namespace app\api\controller;
use apiController\apiController;
use app\api\model\Confirmation_order;

class Orderconfirmation extends apiController{
    public function index(){
        $data=new Confirmation_order();
        $member_id=input('post.id');
        $confirm_status=input('post.confirm_status');
        $date=$data->Confirmation_of_order($member_id,$confirm_status);
        return $date;
    }
}