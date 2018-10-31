<?php
/**
 * Created by PhpStorm.
 * User: 付建军
 * Date: 2018/5/11
 * Time: 10:21
 */

namespace  app\api\model;
use think\Model;
use think\Db;
class Personal_data extends Model{
    /**
     * $id接收的用户ID
     * @param $id
     * @return mixed
     */
    function Personaldata($id){

        $data=Db::table('member')->where("id",$id)->field("mobile,username,avatar,parent_id")->select();
        $pid= $data[0]['parent_id'];
        $res = Db::table('member')->where("id",$pid)->field("username")->select();
        if(count($res)>0){
                array_push($data,$res);
        }else{
            $res[0]['username'] = null;
            array_push($data,$res);
        }
        if(empty($data)){
            $array["type"]=0;
            $array["lang"]=lang('error');
        }else{
            $array["type"]=1;
            $array["lang"]=lang('success');
            $array["data"]=$data;
        }
        return $array;
    }
}