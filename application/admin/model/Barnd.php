<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/7
 * Time: 23:32
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Barnd extends Model
{
    function allread(){
        $table = Db::table('barnd')->where('status','1')->order('sort')->select();
            return $table;
    }
    function read($start,$limit)
    {
        $table = Db::table('barnd')->page($start,$limit)->where('status','1')->order('sort')->select();
        if(count($table)>0){
            return $table;
        }else{
            return false;
        }
    }

    function add()
    {

    }

    function deleup($id)
    {
        $data =Db::table('barnd')->field('id,status,name')->where('id',$id)->update(['status' => '0']);
        
        $array=[];
        if(count($data)<1){
            $array["lang"]=lang('Delete_failure');
        }else{
            $array["lang"]=lang('Delete_success');
        }
        return $array;
    }

    function deleall($id){
        $date=Db::table("barnd")
            ->where("id",'in',$id)
            ->update(["status"=>0]);
        return $date;
    }
}