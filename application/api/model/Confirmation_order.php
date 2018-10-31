<?php
/**
 * Created by PhpStorm.
 * User: 酷炫的勇哥
 * Date: 2018/3/27
 * Time: 18:05
 */
namespace  app\api\model;
use think\Model;

class Confirmation_order extends Model{
    /**
     **$id=用户ID  $confirm_status 判断状态 参数后台传入,确认状态(0：待确认，1：部分确认，2：已确认)
     * 吴正勇
     * return $data 返回 试图Confirmation_order表 查询内润
     * 时间 2018 3.27 18:30
     */
    public function Confirmation_of_order($id,$confirm_status){
        $data=$this->select();
        return $data;
    }
}