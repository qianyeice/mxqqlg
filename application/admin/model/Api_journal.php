<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/10
 * Time: 16:27
 */

namespace app\admin\model;
use think\Model;
use think\Db;
class Api_journal extends Model
{
    /**
     * 接口调用日志
     * Time: 2018\4\11  13:40
     * $page :页数
     * name：冯云祥
     */
    public function api_journal($page=0,$length=10)
    {
        $page =$page * $length;
        $journal = $this->limit($page,$length)->select();
        return $journal;
    }

    public function journal_length()
    {
        $length = $this->count();
        return $length;
    }

    //搜索
    public function search($qian,$hou)
    {
        $journal = $this->select();
        $time_array=array();
        foreach ($journal as $key=>$v){
            if($v["time"]>$qian && $v["time"]<$hou){
                $time_array[$key]=$v;
            }
        }
        return $time_array;
    }
}