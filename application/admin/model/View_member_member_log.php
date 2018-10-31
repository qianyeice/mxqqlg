<?php
/**
 * Name: 谢岸霖
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/4/25
 * Time: 10:38
 */
namespace app\admin\model;

use think\Db;
use think\Model;

class View_member_member_log extends Model{
    function sel($name,$begin,$end){
//        return Db::table('view_member_member_log')->select();
        $data_judge=new Userlevels();
        if ($name==''&&$begin==''&&$end==''){
            $data=$this->where('is_delete','0')->select();
            return $data;
        }else if ($name!=''&&$begin==''&&$end==''){
            $data=$this->where('is_delete','0')->where('username' ,'like','%'.$name.'%')->select();
            $array=$data_judge->judge($data);
            return $array;
        }else if ($name==''&&$begin!=''&&$end!=''){
            $data=$this->where('is_delete','0')->where('time','>',$begin)->where('time','<',$end)->select();
            return $data;
        }else if ($name!=''&&$begin!=''&&$end!=''){
            $data=$this->where('is_delete','0')->where('time','>',$begin)->where('time','<',$end)->where('username' ,'like','%'.$name.'%')->select();
            return $data;
        }else if ($name==''&&$begin!=''&&$end==''){
            $data=$this->where('is_delete','0')->where('time','>',$begin)->select();
            return $data;
        }else if ($name==''&&$begin==''&&$end!=''){
            $data=$this->where('is_delete','0')->where('time','<',$end)->select();
            return $data;
        }else if ($name!=''&&$begin!=''&&$end==''){
            $data=$this->where('is_delete','0')->where('time','>',$begin)->where('username' ,'like','%'.$name.'%')->select();
            return $data;
        }else if ($name!=''&&$begin==''&&$end!=''){
            $data=$this->where('is_delete','0')->where('time','<',$end)->where('username' ,'like','%'.$name.'%')->select();
            return $data;
        }
    }
}