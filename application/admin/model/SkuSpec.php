<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 16:54
 */

namespace app\admin\model;
use think\Db;
use think\Model;

class SkuSpec extends Model
{
    /**
     * 商品规格
     * 陈昌海 2018-3-27 18:09
     * @return array 返回数据
     */
    function read()
    {
        $sub = $this->select();
        //判定是否有数据
        if(count($sub)>0){
            return $sub;
        }else{
            return false;
        }
    }

    function deleup($id)
    {
        $data = Db::table('spec')->field('id,status')->where('id',$id)->update(['status'=>'0']);

        $array=[];
        if(count($data)<1){
            $array["lang"]=lang('Delete_failure');
        }else{
            $array["lang"]=lang('Delete_success');
        }
        return $array;
    }
}