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
class Addbarnd extends Model
{
    /**
     * 品牌添加
     * Time: 2018\4、10  16:20
     * name：陈昌海
     */

    function sel($id,$name,$logo,$descript,$url,$status,$isrecommend,$sort){

        $sqla = Db::table('barnd')->where(['id'=>$id])->order('id','desc')->find();

        //$data['name'] = input
        $array = [];
        if ($id==null && $name!=null){
            //$array['data']= $sqla;
            $sql = Db::table('barnd')->insert(['name'=>$name,'logo'=>$logo,'descript'=>$descript,'url'=>$url,'status'=>$status,'isrecommend'=>$isrecommend,'sort'=>$sort]);

        } else {
            $array['data']= $sqla;
            $sql = Db::table('barnd')->where(['id'=>$id])
                ->update(['name'=>$name,'logo'=>$logo,'descript'=>$descript,'url'=>$url,'status'=>$status,'isrecommend'=>$isrecommend,'sort'=>$sort]);
        }
        return $array;
    }

    function read($id)
    {
        $beef = Db::table('barnd')->where(['id'=>$id])->order('id','desc')->find();

        return $beef;
    }


}