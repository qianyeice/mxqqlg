<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 11:59
 */

namespace app\api\model;
use think\Model;
use think\Db;

class Commission extends Model
{
    /**
     * 胡焱
     * @param $id
     */
    public function dist($member_id,$type){
//        $data=Db::name('get_distribution')->field('p_id')->where('member_id',$member_id)->group('p_id')->order('id','desc')->select();
//        $arr=[];
//        foreach($data as $val ){
//            array_push($arr,$val['p_id']);
//        }
//        $data=Db::name('get_distribution')->field('p_id')->where(array('member_id'=>array('in',$arr)))->group('p_id')->order('id','desc')->select();
//        foreach($data as $val ){
//            array_push($arr,$val['p_id']);
//        }
        $array=[];
        $con=Db::name('get_member')
//        ->where(array('p_id'=>array('in',$arr)))
        ->where('member_id',$member_id)
        ->where('type',$type)->where("money",">","0")
        ->order('get_time desc')
        ->select();
      if (count($con) > 0) {
           $array["type"] = 1;
           $array["lang"] = lang('success');
           $array["data"] = $con;
     } else {
           $array["type"] = 0;
           $array["lang"] = lang('noData');
           $array["data"] = '';
        }
        return $array;
    }



}