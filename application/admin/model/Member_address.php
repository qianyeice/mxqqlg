<?php
namespace app\admin\model;

use think\Model;

class Member_address extends Model{
    /**
     * time:18-4-26 11.29
     * name:邓剑
     * 查看收货地址
     */
    public function memaddress($id){
        return $this->where('member_id',$id)->find();
    }
}