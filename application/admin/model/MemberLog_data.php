<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\4\19 0019
 * Time: 11:21
 */
namespace app\admin\model;

use think\Db;
use think\Model;

Class MemberLog_data extends Model {
    /**
     * 2018 4 19 11:22
     * name:用户余额管理
     * user：白锦国
     */
    function Query_data(){
        $data=$this->query('call member_qure()');
        $data_judge=new Userlevels();
        $array=$data_judge->judge($data);
        return $array;
    }
}