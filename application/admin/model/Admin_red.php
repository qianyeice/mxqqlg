<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13
 * Time: 10:42
 */
namespace app\admin\model;
use think\Db;
use think\Model;
class Admin_red extends Model {
    /**
     * 礼包红包管理
     * time：18-4-12 09:48
     * author:冯云祥
     */
    public function admin_red(){
        $hb=$this->select();
        return count($hb);
    }
    public function is_edit($id){
        $hb=$this->where('id',$id)->select();
        return $hb;
    }
    public function dapage($start,$limt){
        return $this->page($start,$limt)->select();
    }
    /**
     * 礼包红包添加
     * time：18-4-12 09:48
     * author:冯云祥
     */
    public function add($name,$value,$img,$number){
        $data=['name'=> $name,'value'=> $value,'img'=> $img,'number'=>$number];
        $fan=$this->insert($data);
        return $fan;
    }

    /**
     * 礼包红包编辑
     * time：18-4-12 09:48
     * author:冯云祥
     */
    public function edit($id,$name,$value,$img,$number){
        $data=['name'=> $name,'value'=> $value,'img'=> $img,'number'=>$number];
        $fan=$this->where('id',$id)->update($data);
        return $fan;
    }

    /**
     * 礼包红包编辑
     * time：18-7-3 18:38
     * author:蒲胜平
     */
    public function shanchu($id){
        if(is_array($id)){
            foreach($id as $delete){
                $fan=$this->where('id',$delete)->delete();
            }
        }else{
            $fan=$this->where('id',$id)->delete();
        }
        return $fan;
    }
}