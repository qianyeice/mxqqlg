<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\12 0012
 * Time: 9:42
 */
namespace app\admin\model;

use think\Db;

class Logistics_distribution{
    function inquiry($id){
        $data=Db::table('delivery')->where('id',$id)->find();
        if(count($data)){
            return $data;
        }else{
            return lang('fail');
        }
    }
}