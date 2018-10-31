<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\18 0018
 * Time: 14:46
 */
namespace app\admin\model;


use think\Db;

class Userlevels{
  function query_data(){
      $data=Db::table('member_group')->where(array('display'=>'1'))->order("id")->select();
      $array=$this->judge($data);
      return $array;
  }
    function query($start,$limit){
        $data=Db::table('member_group')->where(array('display'=>'1'))->page($start,$limit)->order("id")->select();
        $array=$this->judge($data);
        return $array;
    }
  function judge($data){
      if($data){
          return $data;
      }else{
          return lang('noData');
      }
  }
}