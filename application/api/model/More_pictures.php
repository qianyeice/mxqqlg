<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 17:45
 */
namespace app\api\model;
use think\Db;
use think\Model;
class More_pictures extends Model{

    function Morepictures($catid){

//        echo $catid;exit();
        $data=Db::name('get_morespu')->where('catid',$catid)->field("id,name,sn,content,shop_price,thumb,status")
            ->cache(7200)
            ->select();
//        var_dump($data);
        if(empty($data)){
            $array["type"]=0;
            $array["lang"]='error';
            $array["data"]='';
        }else{
            $array["type"]=1;
            $array["lang"]='success';
            $array["data"]=$data;
        }
        return $array;
    }
}