<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/4/20
 * Time: 16:15
 */
namespace app\admin\model;
use think\Db;
use think\Model;

class Spli_tratio extends Model {
    public function change()
    {
        $data=Db::table('user_grade')
            ->field('bili,yess')
            ->select();
        return $data;
    }
    public function upda($founder,$ini,$parn,$staff){
        Db::table('user_grade')
            ->update(['bili'=>$founder,'yess'=>1,'id'=>4]);
        Db::table('user_grade')
            ->update(['bili'=>$ini,'yess'=>1,'id'=>3]);
        Db::table('user_grade')
            ->update(['bili'=>$parn,'yess'=>1,'id'=>2]);
        Db::table('user_grade')
            ->update(['bili'=>$staff,'yess'=>1,'id'=>1]);
    }

    public function close(){

       $data=Db::table('user_grade')
           ->where("yess","1")
            ->update(['yess'=>0]);
        return true;
    }
}