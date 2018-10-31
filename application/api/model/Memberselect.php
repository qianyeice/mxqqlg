<?php
/**
 * Created by PhpStorm.
 * User: 谢岸霖
 * Date: 2018/3/24
 * Time: 14:25
 */
namespace app\api\model;

use think\Db;
use think\Model;

class Memberselect extends Model{
    function memberquery($openid){
        $data=Db::query('call proc_querymember("'.$openid.'")');
        return $data;
    }

    function membertwo($openid){
        $data=Db::query('call proc_twocodemember("'.$openid.'")');
        return $data;
    }
}