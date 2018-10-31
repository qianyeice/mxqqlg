<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2018/5/4
 * Time: 14:53
 */
namespace app\admin\model;
use think\Db;
use think\Model;
class toplevelclassification extends Model{
    public function classification(){
       $this->find();
    }
}