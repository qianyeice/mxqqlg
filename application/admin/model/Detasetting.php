<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/27
 * Time: 18:17
 */

namespace app\admin\model;

use think\Db;
use think\Model;

class Detasetting extends Model
{
    function sel($id)
    {
        $banana=Db::table('goods_sku')->where('spu_id',$id)->find();
        return $banana;
    }

    /*
     * 添加和修改
     */
    function upsave($id,$prs)
    {
        $data = ['detail'=>$prs];
        $pears = Db::table('goods_sku')->where('spu_id',$id)->update($data);
        return $pears;
    }
}