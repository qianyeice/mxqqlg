<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/25
 * Time: 18:06
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class Typeson extends Model
{
    function addval($val)
    {
//        $beef=$this->query("select last_insert_id()");
//        return $beef;
//        $beef = $this->where()->insert();

//        $beef = $this->save('value',$val)->getLastInsID();
        $data = ['value'=>$val];
        Db::table('typeson')->insert($data);
        $beef = Db::table('typeson')->getLastInsID();

        return $beef;

    }
}