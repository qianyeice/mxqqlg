<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 11:59
 */

namespace app\api\model;
use think\Model;

class GetDistribution extends Model
{
    /**
     * 根据用户id判断未结算、已结算、退单；
     * time:18-3-29 9:13
     * author:冯云祥
     * @param $id 传入用户id;   $type=0:未结算；1:已结算；2:退单；
     */
    public function distribution($id,$type)
    {
        $table = $this->where(array('member_id'=>$id,'type'=>$type))->find();
        if(count($table)>0){
            $array["type"]=1;
            $array["lang"]=lang('success');
        }else{
            $array["type"]=0;
            $array["lang"]=lang('noData');
        }
        $array["data"]=$table;
        return $array;
    }






}