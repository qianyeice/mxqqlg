<?php
namespace app\admin\model;

use think\Db;
use think\Model;

/**
 * 数据库查找后台顶部、左部标题
 * Time: 2018\3\21  10:20
 * name：李磊
*/
class  Admin_menu extends Model{
    public function admin_topMenu(){
        $data=$this->query('call admin_top(0)');
        return $data[0];
    }
    public function admin_leftMenu($id=null){
        if($id==null){
            $data=$this->admin_topMenu();
          $id=$data[0]['id'];
        }
        $data=$this->query('call admin_left('.$id.')');
     return $data[0];
    }
    public function admin_mca($id=null){
        if($id==null){
            $data=$this->admin_leftMenu();
            $id=$data[0]['id'];
    }
       $data=$this->where('id',$id)->find();
        return $data;
    }
}