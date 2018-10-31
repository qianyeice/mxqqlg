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

class Admin_navigation extends Model
{
    public function admin_navigation($id)
    {
        $data=$this->select();
        return $data;
    }
    public function skip($id){
        $data= Db::table('admin_navigation nav')->where('nav.nid',$id)->select();
        return $data;
    }
}